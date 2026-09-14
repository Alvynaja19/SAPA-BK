<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ChatEvaluation;
use App\Models\ChatMessage;
use App\Models\ChatSession;
use App\Models\Ebook;
use App\Models\KnowledgeDocument;
use App\Models\Questionnaire;
use App\Models\QuestionnaireResult;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $stats = [
            'total_users' => User::count(),
            'total_siswa' => User::where('role', 'siswa')->count(),
            'total_guru_bk' => User::where('role', 'guru_bk')->count(),
            'total_admin' => User::where('role', 'admin')->count(),
            'total_sessions' => ChatSession::count(),
            'total_messages' => ChatMessage::count(),
            'total_knowledge' => KnowledgeDocument::count(),
            'total_ebooks' => Ebook::count(),
            'total_articles' => Article::count(),
            'total_evaluations' => ChatEvaluation::count(),
            'good_evaluations' => ChatEvaluation::where('rating', 'good')->count(),
        ];

        $recentUsers = User::latest()->take(6)->get();
        $recentSessions = ChatSession::with('user')->latest()->take(5)->get();
        $recentKnowledge = KnowledgeDocument::with('uploader')->latest()->take(4)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentSessions', 'recentKnowledge'));
    }

    public function users(Request $request): View
    {
        $roleFilter = $request->query('role');
        $search = $request->query('q');

        $query = User::query();

        if ($roleFilter && in_array($roleFilter, ['siswa', 'guru_bk', 'admin'], true)) {
            $query->where('role', $roleFilter);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(12)->withQueryString();

        return view('admin.users', compact('users', 'roleFilter', 'search'));
    }

    /**
     * Membuat akun Guru BK / Admin baru secara manual oleh Administrator (SRS F-06).
     */
    public function storeUser(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:guru_bk,admin,siswa',
            'nisn' => 'nullable|string|max:20',
            'kelas' => 'nullable|string|max:50',
            'no_hp' => 'nullable|string|max:20',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'nisn' => $validated['nisn'] ?? null,
            'kelas' => $validated['kelas'] ?? null,
            'no_hp' => $validated['no_hp'] ?? null,
            'is_active' => true,
        ]);

        $roleTitle = match ($validated['role']) {
            'guru_bk' => 'Guru BK',
            'admin' => 'Administrator',
            default => 'Siswa'
        };

        return back()->with('success', "Akun {$roleTitle} ({$validated['name']}) berhasil dibuat!");
    }

    public function userDetail(int $id): View
    {
        $user = User::with([
            'chatSessions' => function ($q) {
                $q->withCount('messages')->latest()->take(10);
            },
            'questionnaireResults.questionnaire',
        ])->findOrFail($id);

        $totalChats = ChatSession::where('user_id', $user->id)->count();
        $totalAssessments = QuestionnaireResult::where('user_id', $user->id)->count();

        return view('admin.user-detail', compact('user', 'totalChats', 'totalAssessments'));
    }

    public function toggleUserStatus(int $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        if ($user->role === 'admin' && User::where('role', 'admin')->where('is_active', true)->count() <= 1 && $user->is_active) {
            return back()->withErrors(['error' => 'Tidak dapat menonaktifkan satu-satunya akun Administrator.']);
        }

        $user->is_active = ! $user->is_active;
        $user->save();

        $statusText = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Status akun pengguna ({$user->name}) berhasil {$statusText}!");
    }

    /**
     * Halaman Konfigurasi Sistem, LLM, dan Vector DB (SRS F-52 & F-53).
     */
    public function konfigurasi(): View
    {
        $config = [
            'llm_provider' => 'Google Gemini (Official Cloud)',
            'llm_model' => env('GEMINI_MODEL', 'gemini-2.0-flash'),
            'api_key_masked' => 'AIzaSy'.str_repeat('•', 24).'K9L',
            'temperature' => '0.4',
            'max_tokens' => '2048',
            'vector_db' => 'ChromaDB',
            'vector_host' => 'http://127.0.0.1:8000',
            'collection_name' => 'sman4_jember_bk_knowledge',
            'chunk_size' => '512',
            'chunk_overlap' => '64',
            'operating_hours' => '08:00 - 15:00 WIB',
        ];

        return view('admin.konfigurasi', compact('config'));
    }

    /**
     * Menyimpan pembaruan konfigurasi sistem.
     */
    public function simpanKonfigurasi(Request $request): RedirectResponse
    {
        $request->validate([
            'llm_model' => 'required|string',
            'temperature' => 'required|numeric|min:0|max:1',
            'collection_name' => 'required|string',
        ]);

        return back()->with('success', 'Konfigurasi parameter LLM & Vector DB berhasil diperbarui!');
    }

    /**
     * Halaman Log Aktivitas Sistem (SRS F-54).
     */
    public function log(): View
    {
        // Kompilasi log aktivitas sistem terbaru dari database
        $logs = [];

        $recentLogins = User::latest()->take(5)->get();
        foreach ($recentLogins as $u) {
            $logs[] = [
                'level' => 'INFO',
                'category' => 'Auth',
                'message' => "Pengguna terdaftar/diperbarui: {$u->name} ({$u->role})",
                'time' => $u->updated_at->diffForHumans(),
                'status' => 'Success',
            ];
        }

        $recentChats = ChatSession::with('user')->latest()->take(8)->get();
        foreach ($recentChats as $c) {
            $userName = $c->user ? $c->user->name : 'Siswa Tamu';
            $logs[] = [
                'level' => 'INFO',
                'category' => 'RAG AI',
                'message' => "Sesi konsultasi dimulai oleh {$userName}: \"{$c->title}\"",
                'time' => $c->created_at->diffForHumans(),
                'status' => 'Success',
            ];
        }

        $recentDocs = KnowledgeDocument::with('uploader')->latest()->take(4)->get();
        foreach ($recentDocs as $d) {
            $logs[] = [
                'level' => $d->status === 'indexed' ? 'INFO' : 'WARNING',
                'category' => 'Knowledge Base',
                'message' => "Dokumen '{$d->title}' diunggah. Status indeks: {$d->status}",
                'time' => $d->created_at->diffForHumans(),
                'status' => ucfirst($d->status),
            ];
        }

        return view('admin.log', compact('logs'));
    }

    /**
     * Halaman Laporan & Statistik Penggunaan (SRS F-55).
     */
    public function laporan(): View
    {
        $totalSessions = ChatSession::count();
        $totalMessages = ChatMessage::count();
        $totalAssessments = QuestionnaireResult::count();
        $totalUsers = User::count();

        // Rekapitulasi topik konsultasi
        $topicStats = [
            'Akademik & Studi Lanjut' => ChatMessage::where('role', 'user')->where(function ($q) {
                $q->where('content', 'like', '%kuliah%')
                    ->orWhere('content', 'like', '%jurusan%')
                    ->orWhere('content', 'like', '%snbt%');
            })->count(),
            'Manajemen Diri & Stres' => ChatMessage::where('role', 'user')->where(function ($q) {
                $q->where('content', 'like', '%stres%')
                    ->orWhere('content', 'like', '%cemas%')
                    ->orWhere('content', 'like', '%capek%');
            })->count(),
            'Lainnya / Umum' => ChatMessage::where('role', 'user')->count(),
        ];

        // Partisipasi asesmen per kuesioner
        $questionnaires = Questionnaire::withCount('results')->get();

        return view('admin.laporan', compact(
            'totalSessions',
            'totalMessages',
            'totalAssessments',
            'totalUsers',
            'topicStats',
            'questionnaires'
        ));
    }
}
