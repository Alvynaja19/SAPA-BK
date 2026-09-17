<?php

namespace App\Http\Controllers;

use App\Models\ChatSession;
use App\Models\Ebook;
use App\Models\Questionnaire;
use App\Models\QuestionnaireResult;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SiswaController extends Controller
{
    public function dashboard(): View
    {
        $user = Auth::user();
        $totalSessions = ChatSession::where('user_id', $user->id)->count();
        $recentSessions = ChatSession::withCount('messages')->where('user_id', $user->id)->latest()->take(5)->get();
        $questionnaires = Questionnaire::where('is_active', true)->take(3)->get();
        $ebooks = Ebook::latest()->take(4)->get();
        $totalEbooks = Ebook::count();
        $completedTesCount = QuestionnaireResult::where('user_id', $user->id)->distinct('questionnaire_id')->count('questionnaire_id');
        $totalActiveTes = Questionnaire::where('is_active', true)->count();
        $latestEbook = Ebook::latest()->first();
        $pendingQuestionnaire = Questionnaire::where('is_active', true)
            ->whereDoesntHave('results', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->first();

        return view('siswa.dashboard', compact(
            'user',
            'totalSessions',
            'recentSessions',
            'questionnaires',
            'ebooks',
            'totalEbooks',
            'completedTesCount',
            'totalActiveTes',
            'latestEbook',
            'pendingQuestionnaire'
        ));
    }

    public function chat(Request $request, ?int $session_id = null): View
    {
        $user = Auth::user();

        // Ambil sesi AI dan sesi Live Chat Guru BK secara terpisah
        $aiSessions = ChatSession::with('messages')
            ->where('user_id', $user->id)
            ->where(function ($q) {
                $q->where('mode', 'ai')->orWhereNull('mode');
            })
            ->latest()
            ->get();

        // Daftar Guru BK yang tersedia untuk dipilih siswa
        $guruList = User::where('role', 'guru_bk')
            ->where('is_active', true)
            ->select('id', 'name', 'no_hp')
            ->orderBy('name')
            ->get();

        $guruSessions = ChatSession::with(['teacher', 'messages'])
            ->where('user_id', $user->id)
            ->where('mode', 'guru_bk')
            ->latest()
            ->get();

        $activeLiveSession = $guruSessions->where('status', 'active')->first();
        $allSessions = ChatSession::where('user_id', $user->id)->latest()->get();

        // Tentukan mode aktif dan sesi yang sedang dibuka
        $modeQuery = $request->query('mode');
        $isNew = $request->boolean('new');
        $currentSession = null;

        if ($session_id) {
            $currentSession = ChatSession::with(['teacher', 'messages'])->where('user_id', $user->id)->findOrFail($session_id);
            $currentMode = ($currentSession->mode === 'guru_bk') ? 'guru_bk' : 'ai';
        } elseif ($modeQuery === 'live' || $modeQuery === 'guru_bk') {
            $currentMode = 'guru_bk';
            $currentSession = $isNew ? null : ($activeLiveSession ?? $guruSessions->first());
        } else {
            $currentMode = 'ai';
            $currentSession = $isNew ? null : $aiSessions->first();
        }

        // Sesi aktif untuk masing-masing stream (agar stream lain tetap terisi)
        $activeAiSession = ($currentMode === 'ai') ? $currentSession : ($isNew ? null : $aiSessions->first());
        $activeGuruSession = ($currentMode === 'guru_bk') ? $currentSession : ($isNew ? null : ($activeLiveSession ?? $guruSessions->first()));

        // Backward compatibility: $sessions tetap dikirim jika dibutuhkan
        $sessions = ($currentMode === 'guru_bk') ? $guruSessions : $aiSessions;

        return view('siswa.chat', compact(
            'user',
            'guruList',
            'aiSessions',
            'guruSessions',
            'allSessions',
            'sessions',
            'currentSession',
            'currentMode',
            'activeAiSession',
            'activeGuruSession'
        ));
    }

    public function riwayat(Request $request): View
    {
        $user = Auth::user();
        $query = ChatSession::withCount('messages')
            ->with(['messages' => function ($q) {
                $q->latest()->take(1);
            }])
            ->where('user_id', $user->id);

        $search = trim((string) $request->query('q', ''));
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhereHas('messages', function ($mq) use ($search) {
                        $mq->where('content', 'like', "%{$search}%");
                    });
            });
        }

        $modeFilter = $request->query('mode', 'all');
        if ($modeFilter === 'guru_bk') {
            $query->where('mode', 'guru_bk');
        } elseif ($modeFilter === 'ai') {
            $query->where(function ($q) {
                $q->where('mode', 'ai')->orWhereNull('mode');
            });
        }

        $sessions = $query->latest()->paginate(10)->withQueryString();
        $totalSessions = ChatSession::where('user_id', $user->id)->count();
        $totalAiSessions = ChatSession::where('user_id', $user->id)
            ->where(function ($q) {
                $q->where('mode', 'ai')->orWhereNull('mode');
            })
            ->count();
        $totalGuruSessions = ChatSession::where('user_id', $user->id)
            ->where('mode', 'guru_bk')
            ->count();
        $lastSession = ChatSession::where('user_id', $user->id)->latest()->first();

        return view('siswa.riwayat', compact(
            'sessions',
            'search',
            'modeFilter',
            'totalSessions',
            'totalAiSessions',
            'totalGuruSessions',
            'lastSession'
        ));
    }

    public function hapusSesi(Request $request, int $id): JsonResponse|RedirectResponse
    {
        $user = Auth::user();
        $session = ChatSession::where('user_id', $user->id)->findOrFail($id);

        // Proteksi: Khusus Chatbot AI saja yang dapat dihapus siswa
        if ($session->mode === 'guru_bk') {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Arsip Live Chat Guru BK merupakan rekaman resmi bimbingan konseling dan tidak dapat dihapus.',
                ], 403);
            }

            return redirect()->back()->with('error', 'Arsip Live Chat Guru BK merupakan rekaman resmi bimbingan konseling dan tidak dapat dihapus.');
        }

        $session->delete();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Arsip percakapan Chatbot AI berhasil dihapus.',
            ]);
        }

        return redirect()->back()->with('success', 'Arsip percakapan Chatbot AI berhasil dihapus.');
    }

    public function ebookAkses(): View
    {
        $ebooks = Ebook::latest()->paginate(12);

        return view('siswa.ebook', compact('ebooks'));
    }

    public function tes(): View
    {
        $user = Auth::user();
        $questionnaires = Questionnaire::where('is_active', true)->with(['results' => function ($q) use ($user) {
            $q->where('user_id', $user->id);
        }])->get();

        return view('siswa.tes', compact('questionnaires'));
    }

    public function isiTes(int $id): View
    {
        $questionnaire = Questionnaire::with('questions')->findOrFail($id);

        return view('siswa.isi-tes', compact('questionnaire'));
    }

    public function simpanTes(Request $request, int $id): RedirectResponse
    {
        $questionnaire = Questionnaire::findOrFail($id);
        $user = Auth::user();

        $answers = $request->input('answers', []);
        $score = count($answers) * 10; // Simple scoring formula

        $result = QuestionnaireResult::create([
            'questionnaire_id' => $questionnaire->id,
            'user_id' => $user->id,
            'answers' => $answers,
            'score' => $score,
        ]);

        return redirect()->route('siswa.tes.hasil', $result->id)->with('success', 'Kuesioner berhasil diselesaikan!');
    }

    public function hasilTes(int $id): View
    {
        $user = Auth::user();
        $result = QuestionnaireResult::with('questionnaire')->where('user_id', $user->id)->findOrFail($id);

        return view('siswa.hasil-tes', compact('result'));
    }
}
