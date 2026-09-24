<?php

namespace App\Http\Controllers;

use App\Events\LiveChatMessageSent;
use App\Events\LiveChatSessionClosed;
use App\Models\Article;
use App\Models\ChatEvaluation;
use App\Models\ChatMessage;
use App\Models\ChatSession;
use App\Models\Ebook;
use App\Models\Faq;
use App\Models\KnowledgeDocument;
use App\Models\Questionnaire;
use App\Models\QuestionnaireQuestion;
use App\Models\QuestionnaireResult;
use App\Models\User;
use App\Services\DashboardAnalyticsService;
use App\Services\RssArticleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class GuruBkController extends Controller
{
    public function dashboard(DashboardAnalyticsService $analytics): View
    {
        $counselorId = Auth::id();

        $stats = [
            'total_siswa' => User::where('role', 'siswa')->count(),
            'total_ai_sessions' => ChatSession::where(function ($q) {
                $q->where('mode', 'ai')->orWhereNull('mode');
            })->count(),
            'total_live_sessions' => ChatSession::where('mode', 'guru_bk')->count(),
            'my_live_sessions' => ChatSession::where('mode', 'guru_bk')->where('teacher_id', $counselorId)->count(),
            'total_percakapan' => ChatSession::count(),
            'total_ebook' => Ebook::count(),
            'total_artikel' => Article::count(),
            'active_queue' => ChatSession::where('teacher_id', $counselorId)
                ->where('mode', 'guru_bk')
                ->where('status', 'active')
                ->count(),
            'pending_evaluations_count' => ChatMessage::where('role', 'assistant')->doesntHave('evaluation')->count(),
        ];

        $trendData = $analytics->getTrendData($counselorId);
        $popularTopics = $analytics->getPopularTopics();
        $recentSessions = $analytics->getRecentSessions(10, $counselorId);
        $pendingEvaluations = ChatMessage::where('role', 'assistant')->doesntHave('evaluation')->latest()->take(5)->get();

        return view('bk.dashboard', compact(
            'stats',
            'trendData',
            'popularTopics',
            'recentSessions',
            'pendingEvaluations'
        ));
    }

    public function siswa(): View
    {
        $siswa = User::where('role', 'siswa')->latest()->paginate(15);

        return view('bk.siswa', compact('siswa'));
    }

    /**
     * Riwayat Percakapan Chatbot AI Siswa.
     * Khusus menampilkan sesi konsultasi digital antara siswa dengan Chatbot / AI Gemini.
     */
    public function percakapan(Request $request): View
    {
        $query = ChatSession::with(['user', 'messages'])
            ->where(function ($q) {
                $q->where('mode', 'ai')->orWhereNull('mode');
            });

        if ($request->filled('q')) {
            $search = trim($request->input('q'));
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%")
                            ->orWhere('kelas', 'like', "%{$search}%")
                            ->orWhere('nisn', 'like', "%{$search}%");
                    });
            });
        }

        $sessions = $query->latest()->paginate(15)->withQueryString();
        $totalAi = ChatSession::where(fn ($q) => $q->where('mode', 'ai')->orWhereNull('mode'))->count();
        $totalLive = ChatSession::where('mode', 'guru_bk')->count();

        return view('bk.percakapan', compact('sessions', 'totalAi', 'totalLive'));
    }

    /**
     * Riwayat Sesi Live Chat Konseling Guru BK.
     * Khusus menampilkan sesi konsultasi tatap maya langsung antara siswa dan Guru BK.
     */
    public function riwayatLiveChat(Request $request): View
    {
        $query = ChatSession::with(['user', 'teacher', 'closedBy', 'messages'])
            ->where('mode', 'guru_bk');

        $user = Auth::user();
        if ($user->role === 'guru_bk') {
            if ($request->input('scope') !== 'all') {
                $query->where('teacher_id', $user->id);
            }
        } elseif ($request->filled('teacher_id')) {
            $query->where('teacher_id', $request->input('teacher_id'));
        }

        if ($request->filled('status') && in_array($request->status, ['active', 'closed'], true)) {
            $query->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $search = trim($request->input('q'));
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%")
                            ->orWhere('kelas', 'like', "%{$search}%")
                            ->orWhere('nisn', 'like', "%{$search}%");
                    })
                    ->orWhereHas('teacher', function ($tq) use ($search) {
                        $tq->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $sessions = $query->latest()->paginate(15)->withQueryString();
        $totalAi = ChatSession::where(fn ($q) => $q->where('mode', 'ai')->orWhereNull('mode'))->count();
        $totalLive = ChatSession::where('mode', 'guru_bk')->count();
        $teachers = User::where('role', 'guru_bk')->orderBy('name')->get();

        return view('bk.riwayat-live-chat', compact('sessions', 'totalAi', 'totalLive', 'teachers'));
    }

    public function detailPercakapan(int $id): View
    {
        $session = ChatSession::with(['user', 'teacher', 'closedBy', 'messages.evaluation'])->findOrFail($id);

        return view('bk.percakapan-detail', compact('session'));
    }

    public function liveChat(): View
    {
        $counselorId = Auth::id();

        // 1. Panel Antrean Siswa Konseling: HARUS difilter berdasarkan teacher_id milik Guru BK yang sedang login
        $activeQueue = ChatSession::with(['user', 'messages' => fn ($q) => $q->latest()->take(1)])
            ->where('teacher_id', $counselorId)
            ->where('mode', 'guru_bk')
            ->where('status', 'active')
            ->orderByDesc('updated_at')
            ->get();

        $selectedSession = $activeQueue->first();

        // Load pesan sesi pertama jika ada antrean
        $initialMessages = $selectedSession
            ? ChatMessage::where('session_id', $selectedSession->id)->orderBy('created_at')->get()
            : collect();

        // Backward compatibility untuk variabel view yang sudah ada
        $siswaList = $activeQueue->map(fn ($s) => $s->user)->filter()->unique('id');

        return view('bk.live-chat', compact('activeQueue', 'selectedSession', 'initialMessages', 'siswaList'));
    }

    /**
     * API Real-time Antrean Siswa Konseling khusus Guru BK yang login.
     */
    public function liveChatQueue(): JsonResponse
    {
        $counselorId = Auth::id();

        $queue = ChatSession::with(['user', 'messages' => fn ($q) => $q->latest()->take(1)])
            ->where('teacher_id', $counselorId)
            ->where('mode', 'guru_bk')
            ->where('status', 'active')
            ->orderByDesc('updated_at')
            ->get()
            ->map(function ($s) {
                $latestMessage = $s->messages->first();

                return [
                    'session_id' => $s->id,
                    'student_id' => $s->user?->id,
                    'name' => $s->user?->name ?? 'Siswa',
                    'kelas' => $s->user?->kelas ?? 'Kelas Siswa',
                    'initial' => strtoupper(substr($s->user?->name ?? 'S', 0, 2)),
                    'status' => $s->status,
                    'latest_message' => $latestMessage?->content ?? 'Sesi konseling baru dimulai...',
                    'time' => $latestMessage?->created_at?->format('H:i') ?? $s->created_at?->format('H:i'),
                ];
            });

        return response()->json([
            'success' => true,
            'count' => $queue->count(),
            'data' => $queue,
        ]);
    }

    /**
     * API Riwayat pesan percakapan antara Guru BK dan Siswa terpilih.
     */
    public function liveChatMessages(int $sessionId): JsonResponse
    {
        $counselorId = Auth::id();

        $session = ChatSession::with('user')->findOrFail($sessionId);

        // Aturan Bisnis: Isolasi data konseling antar Guru BK
        if ($session->teacher_id !== $counselorId) {
            return response()->json([
                'success' => false,
                'message' => 'Akses ditolak. Sesi konseling ini ditangani oleh Guru BK lain.',
            ], 403);
        }

        // Tandai pesan siswa sebagai telah dibaca
        ChatMessage::where('session_id', $sessionId)
            ->where('role', 'user')
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        $messages = ChatMessage::where('session_id', $sessionId)
            ->orderBy('created_at')
            ->get()
            ->map(fn ($m) => [
                'id' => $m->id,
                'role' => $m->role,
                'sender_id' => $m->sender_id,
                'content' => $m->content,
                'time' => $m->created_at ? $m->created_at->format('H:i').' WIB' : '',
                'metadata' => $m->metadata,
            ]);

        return response()->json([
            'success' => true,
            'session' => [
                'id' => $session->id,
                'status' => $session->status,
                'student_name' => $session->user?->name ?? 'Siswa',
                'student_class' => $session->user?->kelas ?? 'Kelas Siswa',
                'is_closed' => $session->isClosed(),
            ],
            'messages' => $messages,
        ]);
    }

    /**
     * API Mengirim pesan balasan dari Guru BK ke Siswa.
     */
    public function sendLiveChatMessage(Request $request, int $sessionId): JsonResponse
    {
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $counselorId = Auth::id();
        $session = ChatSession::where('id', $sessionId)->where('teacher_id', $counselorId)->firstOrFail();

        // Aturan Bisnis: Input terkunci jika sesi berstatus closed
        if ($session->isClosed()) {
            return response()->json([
                'success' => false,
                'message' => 'Sesi konseling telah diakhiri. Tidak dapat mengirim pesan baru.',
            ], 422);
        }

        $message = ChatMessage::create([
            'session_id' => $session->id,
            'sender_id' => $counselorId,
            'role' => 'counselor',
            'content' => $request->message,
            'metadata' => [
                'counselor' => Auth::user()->name,
            ],
        ]);

        $session->touch();

        $messageData = [
            'id' => $message->id,
            'role' => 'counselor',
            'content' => $message->content,
            'time' => $message->created_at ? $message->created_at->format('H:i').' WIB' : 'Baru saja',
            'sender_id' => $counselorId,
        ];

        try {
            broadcast(new LiveChatMessageSent($session->id, $messageData, $session->status));
        } catch (\Throwable) {
            // Abaikan kegagalan socket agar respons HTTP tetap sukses jika server reverb belum berjalan
        }

        return response()->json([
            'success' => true,
            'message' => $messageData,
        ]);
    }

    /**
     * API Mengakhiri/menyelesaikan konseling (mengubah status menjadi closed).
     */
    public function closeLiveChatSession(int $sessionId): JsonResponse
    {
        $counselorId = Auth::id();
        $session = ChatSession::where('id', $sessionId)->where('teacher_id', $counselorId)->firstOrFail();

        $session->update([
            'status' => 'closed',
            'closed_at' => now(),
            'closed_by' => $counselorId,
        ]);

        try {
            broadcast(new LiveChatSessionClosed($session->id, Auth::user()->name));
        } catch (\Throwable) {
            // Abaikan
        }

        return response()->json([
            'success' => true,
            'message' => 'Sesi konseling berhasil diakhiri.',
            'session_id' => $session->id,
            'status' => 'closed',
        ]);
    }

    public function ebook(): View
    {
        $ebooks = Ebook::with('uploader')->latest()->paginate(10);

        return view('bk.ebook', compact('ebooks'));
    }

    public function simpanEbook(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|mimes:pdf|max:20480',
            'is_public' => 'boolean',
        ]);

        $path = $request->file('file')->store('ebooks', 'public');

        Ebook::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'file_path' => $path,
            'is_public' => $request->boolean('is_public'),
            'uploaded_by' => Auth::id(),
        ]);

        return back()->with('success', 'E-Book berhasil diunggah!');
    }

    public function hapusEbook(int $id): RedirectResponse
    {
        $ebook = Ebook::findOrFail($id);
        $ebook->delete();

        return back()->with('success', 'E-Book berhasil dihapus.');
    }

    public function artikel(Request $request): View
    {
        $query = Article::with('author');

        if ($request->filled('q')) {
            $search = trim($request->input('q'));
            $query->where('title', 'like', "%{$search}%");
        }

        if ($request->filled('category') && $request->input('category') !== 'all') {
            $query->where('category', $request->input('category'));
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->input('date'));
        }

        $articles = $query->latest()->paginate(10)->withQueryString();

        $categoryCounts = [
            'all' => Article::count(),
            'tips_ptn' => Article::where('category', 'tips_ptn')->count(),
            'kesehatan_mental' => Article::where('category', 'kesehatan_mental')->count(),
            'umum' => Article::whereNotIn('category', ['tips_ptn', 'kesehatan_mental'])->count(),
        ];

        return view('bk.artikel', compact('articles', 'categoryCounts'));
    }

    public function simpanArtikel(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:50',
            'content' => 'required|string',
            'is_published' => 'boolean',
        ]);

        Article::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']).'-'.Str::random(5),
            'category' => $validated['category'] ?? 'umum',
            'content' => $validated['content'],
            'is_published' => $request->boolean('is_published'),
            'author_id' => Auth::id(),
        ]);

        return back()->with('success', 'Artikel berhasil diterbitkan!');
    }

    public function hapusArtikel(int $id): RedirectResponse
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return back()->with('success', 'Artikel berhasil dihapus.');
    }

    public function syncRssArtikel(Request $request, RssArticleService $rssService): RedirectResponse
    {
        $category = $request->input('category', 'tips_ptn');
        if (! in_array($category, ['tips_ptn', 'kesehatan_mental', 'all'], true)) {
            $category = 'tips_ptn';
        }

        if ($category === 'all') {
            $res1 = $rssService->syncByCategory('tips_ptn', 4, Auth::id());
            $res2 = $rssService->syncByCategory('kesehatan_mental', 4, Auth::id());
            $totalSynced = $res1['synced'] + $res2['synced'];
        } else {
            $res = $rssService->syncByCategory($category, 5, Auth::id());
            $totalSynced = $res['synced'];
        }

        $categoryLabel = match ($category) {
            'tips_ptn' => 'Tips Lolos PTN & SNBP',
            'kesehatan_mental' => 'Kesehatan Mental Remaja',
            default => 'Semua Topik (PTN & Kesehatan Mental)',
        };

        if ($totalSynced > 0) {
            return back()->with('success', "Berhasil menarik {$totalSynced} artikel edukasi baru seputar {$categoryLabel}!");
        }

        return back()->with('info', "Artikel terbaru untuk {$categoryLabel} sudah tersinkronisasi (tidak ada artikel baru).");
    }

    public function knowledgeBase(): View
    {
        $documents = KnowledgeDocument::with('uploader')->latest()->paginate(10);

        return view('bk.knowledge-base', compact('documents'));
    }

    public function simpanKnowledge(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,docx,txt|max:10240',
        ]);

        $path = $request->file('file')->store('knowledge_docs', 'public');

        KnowledgeDocument::create([
            'title' => $validated['title'],
            'file_path' => $path,
            'status' => 'pending',
            'uploaded_by' => Auth::id(),
        ]);

        return back()->with('success', 'Dokumen pedoman berhasil diunggah dan dijadwalkan untuk sinkronisasi RAG!');
    }

    public function tes(): View
    {
        $questionnaires = Questionnaire::withCount('results')->latest()->paginate(10);

        return view('bk.tes', compact('questionnaires'));
    }

    /**
     * Membuat kuesioner asesmen baru (SRS F-46).
     */
    public function simpanTes(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'is_active' => 'boolean',
        ]);

        Questionnaire::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'created_by' => Auth::id(),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return back()->with('success', 'Kuesioner asesmen baru berhasil dibuat!');
    }

    public function hasilTes(int $id): View
    {
        $questionnaire = Questionnaire::findOrFail($id);
        $results = QuestionnaireResult::with('user')->where('questionnaire_id', $id)->latest()->paginate(15);

        return view('bk.hasil-tes', compact('questionnaire', 'results'));
    }

    public function updateTes(Request $request, int $id): RedirectResponse
    {
        $questionnaire = Questionnaire::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $questionnaire->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'is_active' => $request->boolean('is_active', true),
        ]);

        return back()->with('success', 'Kuesioner asesmen berhasil diperbarui!');
    }

    public function hapusTes(int $id): RedirectResponse
    {
        $questionnaire = Questionnaire::findOrFail($id);
        $questionnaire->delete();

        return redirect()->route('bk.tes')->with('success', 'Kuesioner beserta seluruh butir soal berhasil dihapus!');
    }

    public function kelolaSoal(int $id): View
    {
        $questionnaire = Questionnaire::with('questions')->findOrFail($id);

        return view('bk.soal', compact('questionnaire'));
    }

    public function simpanSoal(Request $request, int $id): RedirectResponse
    {
        $questionnaire = Questionnaire::findOrFail($id);

        $validated = $request->validate([
            'question_text' => 'required|string',
            'options' => 'required|array|min:2',
            'options.*.label' => 'required|string',
            'options.*.value' => 'required|string',
            'order' => 'nullable|integer',
        ]);

        $nextOrder = $validated['order'] ?? (($questionnaire->questions()->max('order') ?? 0) + 1);

        QuestionnaireQuestion::create([
            'questionnaire_id' => $questionnaire->id,
            'question_text' => $validated['question_text'],
            'options' => array_values($validated['options']),
            'order' => $nextOrder,
        ]);

        return back()->with('success', 'Butir soal baru berhasil ditambahkan!');
    }

    public function updateSoal(Request $request, int $id, int $soalId): RedirectResponse
    {
        $questionnaire = Questionnaire::findOrFail($id);
        $question = QuestionnaireQuestion::where('questionnaire_id', $questionnaire->id)->findOrFail($soalId);

        $validated = $request->validate([
            'question_text' => 'required|string',
            'options' => 'required|array|min:2',
            'options.*.label' => 'required|string',
            'options.*.value' => 'required|string',
            'order' => 'nullable|integer',
        ]);

        $question->update([
            'question_text' => $validated['question_text'],
            'options' => array_values($validated['options']),
            'order' => $validated['order'] ?? $question->order,
        ]);

        return back()->with('success', 'Butir soal asesmen berhasil diperbarui!');
    }

    public function hapusSoal(int $id, int $soalId): RedirectResponse
    {
        $questionnaire = Questionnaire::findOrFail($id);
        $question = QuestionnaireQuestion::where('questionnaire_id', $questionnaire->id)->findOrFail($soalId);
        $question->delete();

        return back()->with('success', 'Butir soal asesmen berhasil dihapus!');
    }

    public function evaluasi(): View
    {
        $messages = ChatMessage::with(['session.user', 'evaluation'])->where('role', 'assistant')->latest()->paginate(15);

        return view('bk.evaluasi', compact('messages'));
    }

    public function simpanEvaluasi(Request $request, int $messageId): RedirectResponse
    {
        $validated = $request->validate([
            'rating' => 'required|in:good,bad',
            'note' => 'nullable|string',
        ]);

        ChatEvaluation::updateOrCreate(
            ['message_id' => $messageId],
            [
                'evaluated_by' => Auth::id(),
                'rating' => $validated['rating'],
                'note' => $validated['note'] ?? null,
            ]
        );

        return back()->with('success', 'Evaluasi kualitas jawaban berhasil disimpan!');
    }

    public function faq(): View
    {
        $faqs = Faq::orderBy('order')->paginate(15);

        return view('bk.faq', compact('faqs'));
    }

    public function simpanFaq(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
            'order' => 'integer',
        ]);

        Faq::create([
            'question' => $validated['question'],
            'answer' => $validated['answer'],
            'order' => $validated['order'] ?? 0,
            'is_active' => true,
        ]);

        return back()->with('success', 'FAQ baru berhasil ditambahkan.');
    }
}
