<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ChatSession;
use App\Models\Ebook;
use App\Models\Questionnaire;
use App\Models\QuestionnaireResult;
use App\Models\User;
use App\Services\EbookPdfGenerator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
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
        $totalActiveTes = Questionnaire::where('is_active', true)->whereHas('questions')->count();
        $latestEbook = Ebook::latest()->first();

        // Evaluasi kondisi pemberitahuan tes & kuis siswa
        $testNotificationState = 'none'; // 'none', 'pending', 'accepted'
        $pendingQuestionnaire = null;
        $latestCompletedResult = null;

        if ($totalActiveTes > 0) {
            $pendingQuestionnaire = Questionnaire::where('is_active', true)
                ->whereHas('questions')
                ->whereDoesntHave('results', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                })
                ->first();

            if ($pendingQuestionnaire) {
                $testNotificationState = 'pending';
            } else {
                // Semua tes aktif telah diselesaikan oleh siswa
                $latestCompletedResult = QuestionnaireResult::with('questionnaire')
                    ->where('user_id', $user->id)
                    ->latest()
                    ->first();

                if ($latestCompletedResult) {
                    $testNotificationState = 'accepted';
                }
            }
        }

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
            'pendingQuestionnaire',
            'latestCompletedResult',
            'testNotificationState'
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
            ->select('id', 'name', 'no_hp', 'avatar', 'email')
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

        // Cek apakah ada rujukan fitur/modul/tes/artikel yang ingin didiskusikan siswa
        $refType = $request->query('ref');
        $refId = $request->query('ref_id', $request->query('id'));
        $initialAttachment = null;

        if ($refType && $refId) {
            if ($refType === 'ebook') {
                $ebook = Ebook::with('uploader')->find($refId);
                if ($ebook) {
                    $initialAttachment = [
                        'type' => 'ebook',
                        'type_label' => 'Modul E-Book',
                        'id' => $ebook->id,
                        'title' => $ebook->title,
                        'subtitle' => $ebook->uploader?->name ?? 'Guru BK SMAN 4 Jember',
                        'description' => Str::limit($ebook->description ?? 'Modul materi bimbingan konseling.', 120),
                        'cover_url' => $ebook->cover_path ? asset('storage/'.$ebook->cover_path) : null,
                        'url' => route('ebook.detail', $ebook->id),
                        'badge' => 'E-Book Perpustakaan BK',
                    ];
                }
            } elseif ($refType === 'tes' || $refType === 'kuis') {
                $result = QuestionnaireResult::with('questionnaire')->where('user_id', $user->id)->find($refId);
                if ($result) {
                    $initialAttachment = [
                        'type' => 'tes',
                        'type_label' => 'Hasil Kuesioner & Tes',
                        'id' => $result->id,
                        'title' => $result->questionnaire?->title ?? 'Hasil Asesmen Minat Bakat',
                        'subtitle' => 'Skor Evaluasi: '.$result->score.' Poin',
                        'description' => 'Diselesaikan pada '.$result->created_at?->format('d M Y, H:i').' WIB. Menunggu telaah dan konsultasi lanjutan dari Guru BK.',
                        'score' => $result->score,
                        'url' => route('siswa.tes.hasil', $result->id),
                        'badge' => 'Hasil Asesmen Selesai',
                    ];
                } else {
                    $questionnaire = Questionnaire::find($refId);
                    if ($questionnaire) {
                        $latestResult = QuestionnaireResult::where('user_id', $user->id)->where('questionnaire_id', $questionnaire->id)->latest()->first();
                        $initialAttachment = [
                            'type' => 'tes',
                            'type_label' => 'Instrumen Kuesioner & Tes',
                            'id' => $latestResult ? $latestResult->id : $questionnaire->id,
                            'title' => $questionnaire->title,
                            'subtitle' => $latestResult ? 'Skor: '.$latestResult->score.' Poin' : 'Instrumen Belum Dikerjakan',
                            'description' => Str::limit($questionnaire->description ?? '', 120),
                            'score' => $latestResult?->score,
                            'url' => $latestResult ? route('siswa.tes.hasil', $latestResult->id) : route('siswa.tes.isi', $questionnaire->id),
                            'badge' => 'Kuesioner BK',
                        ];
                    }
                }
            } elseif ($refType === 'artikel' || $refType === 'article') {
                $article = Article::with('author')->where('id', $refId)->orWhere('slug', $refId)->first();
                if ($article) {
                    $initialAttachment = [
                        'type' => 'artikel',
                        'type_label' => 'Artikel Edukatif BK',
                        'id' => $article->id,
                        'title' => $article->title,
                        'subtitle' => 'Penulis: '.($article->author?->name ?? $article->source_name ?? 'Guru BK SMAN 4 Jember'),
                        'description' => Str::limit(strip_tags($article->content ?? ''), 120),
                        'cover_url' => $article->thumbnail ? asset('storage/'.$article->thumbnail) : null,
                        'url' => route('article.detail', $article->slug),
                        'badge' => 'Artikel Bimbingan',
                    ];
                }
            }

            // Jika ada attachment yang dirujuk, alihkan mode ke Live Chat Guru BK
            if ($initialAttachment) {
                $currentMode = 'guru_bk';
            }
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
            'activeGuruSession',
            'initialAttachment'
        ));
    }

    public function riwayat(Request $request): View
    {
        $user = Auth::user();
        $query = ChatSession::withCount('messages')
            ->with(['messages' => function ($q) {
                $q->latest()->take(1);
            }])
            ->where('user_id', $user->id)
            ->where(function ($q) {
                $q->where('mode', 'ai')->orWhereNull('mode');
            });

        $search = trim((string) $request->query('q', ''));
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhereHas('messages', function ($mq) use ($search) {
                        $mq->where('content', 'like', "%{$search}%");
                    });
            });
        }

        $sessions = $query->latest()->paginate(10)->withQueryString();
        $totalSessions = ChatSession::where('user_id', $user->id)
            ->where(function ($q) {
                $q->where('mode', 'ai')->orWhereNull('mode');
            })
            ->count();
        $totalAiSessions = $totalSessions;
        $lastSession = ChatSession::where('user_id', $user->id)
            ->where(function ($q) {
                $q->where('mode', 'ai')->orWhereNull('mode');
            })
            ->latest()
            ->first();

        return view('siswa.riwayat', compact(
            'sessions',
            'search',
            'totalSessions',
            'totalAiSessions',
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
        $ebooks = Ebook::with('uploader')->latest()->get();

        $stats = [
            'total' => $ebooks->count(),
            'public' => $ebooks->where('is_public', true)->count(),
            'internal' => $ebooks->where('is_public', false)->count(),
        ];

        return view('siswa.ebook', compact('ebooks', 'stats'));
    }

    /**
     * Mengalirkan berkas PDF modul internal secara langsung ke peramban.
     */
    public function streamPdf(int $id)
    {
        $ebook = Ebook::findOrFail($id);

        $filePath = $this->resolveEbookPath($ebook->file_path);

        // Jika berkas belum ada di server atau rusak/kosong (< 50 byte), buat dokumen PDF resmi otomatis
        if (! $filePath || filesize($filePath) < 50) {
            $generatedPath = $this->generateFallbackPdf($ebook);
            if ($generatedPath && file_exists($generatedPath)) {
                $filePath = $generatedPath;
            } else {
                return response()->view('siswa.ebook-missing', [
                    'ebook' => $ebook,
                ], 404);
            }
        }

        $filename = basename($ebook->file_path ?: 'modul_'.$ebook->id.'.pdf');
        if (! str_ends_with(strtolower($filename), '.pdf')) {
            $filename .= '.pdf';
        }

        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$filename.'"',
            'Accept-Ranges' => 'bytes',
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }

    /**
     * Mengunduh berkas PDF modul internal.
     */
    public function unduhPdf(int $id)
    {
        $ebook = Ebook::findOrFail($id);

        $filePath = $this->resolveEbookPath($ebook->file_path);

        if (! $filePath || filesize($filePath) < 50) {
            $generatedPath = $this->generateFallbackPdf($ebook);
            if ($generatedPath && file_exists($generatedPath)) {
                $filePath = $generatedPath;
            } else {
                return back()->with('error', 'Berkas modul belum tersedia secara fisik di server.');
            }
        }

        $cleanTitle = preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $ebook->title);

        return response()->download($filePath, $cleanTitle.'.pdf');
    }

    /**
     * Membuat dokumen PDF sampel resmi jika berkas fisik modul belum tersedia di server.
     */
    protected function generateFallbackPdf(Ebook $ebook): ?string
    {
        $dir = storage_path('app/public/ebooks');
        if (! is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }

        $filename = basename($ebook->file_path ?: 'modul_'.$ebook->id.'.pdf');
        if (! str_ends_with(strtolower($filename), '.pdf')) {
            $filename .= '.pdf';
        }
        $destPath = $dir.'/'.$filename;

        $ok = EbookPdfGenerator::generateForInternalEbook($ebook, $destPath);

        return $ok && file_exists($destPath) ? $destPath : null;
    }

    /**
     * Mencari path absolut berkas fisik e-book di berbagai kemungkinan lokasi penyimpanan.
     */
    protected function resolveEbookPath(?string $relativePath): ?string
    {
        if (empty($relativePath)) {
            return null;
        }

        $candidates = [
            storage_path('app/public/'.$relativePath),
            storage_path('app/'.$relativePath),
            public_path('storage/'.$relativePath),
            base_path('storage/app/public/'.$relativePath),
        ];

        foreach ($candidates as $candidate) {
            if (file_exists($candidate) && is_file($candidate)) {
                return $candidate;
            }
        }

        return null;
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

    /**
     * Endpoint API status notifikasi kuesioner real-time untuk dashboard siswa.
     */
    public function testNotificationStatus(Request $request): JsonResponse
    {
        $user = Auth::user();
        if (! $user) {
            return response()->json(['success' => false, 'state' => 'none'], 401);
        }

        $totalActiveTes = Questionnaire::where('is_active', true)->whereHas('questions')->count();

        if ($totalActiveTes === 0) {
            return response()->json([
                'success' => true,
                'state' => 'none',
            ]);
        }

        $pending = Questionnaire::where('is_active', true)
            ->whereHas('questions')
            ->whereDoesntHave('results', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->first();

        if ($pending) {
            return response()->json([
                'success' => true,
                'state' => 'pending',
                'data' => [
                    'id' => $pending->id,
                    'title' => $pending->title,
                    'description' => $pending->description ?: 'Belum kamu isi. Hasilnya membantu Guru BK memahami cara belajar dan pengembangan dirimu yang paling cocok.',
                    'isi_url' => route('siswa.tes.isi', $pending->id),
                    'chat_url' => route('siswa.chat', ['mode' => 'live', 'ref' => 'tes', 'ref_id' => $pending->id]),
                ],
            ]);
        }

        $latestResult = QuestionnaireResult::with('questionnaire')
            ->where('user_id', $user->id)
            ->latest()
            ->first();

        if ($latestResult) {
            return response()->json([
                'success' => true,
                'state' => 'accepted',
                'data' => [
                    'id' => $latestResult->id,
                    'title' => $latestResult->questionnaire?->title ?: 'Asesmen Minat & Bakat',
                    'score' => $latestResult->score,
                    'description' => 'Asesmen telah kamu selesaikan dan telah diterima (ter-accept) oleh Guru BK. Hasil dan rekomendasi bimbingan sudah siap kamu pelajari.',
                    'hasil_url' => route('siswa.tes.hasil', $latestResult->id),
                    'chat_url' => route('siswa.chat', ['mode' => 'live', 'ref' => 'tes', 'ref_id' => $latestResult->id]),
                ],
            ]);
        }

        return response()->json([
            'success' => true,
            'state' => 'none',
        ]);
    }
}
