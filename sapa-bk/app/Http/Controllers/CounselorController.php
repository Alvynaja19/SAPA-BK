<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ChatSession;
use App\Models\ChatMessage;
use App\Models\Ebook;
use App\Models\Article;
use App\Models\KnowledgeDocument;
use App\Models\Questionnaire;
use App\Models\QuestionnaireResult;
use App\Models\ChatEvaluation;
use App\Models\Faq;

class CounselorController extends Controller
{
    /** Dashboard Guru BK — /bk/dashboard */
    public function dashboard()
    {
        $totalSiswa          = User::where('role', 'siswa')->count();
        $totalPercakapan     = ChatSession::count();
        $totalEbook          = Ebook::count();
        $totalArtikel        = Article::count();
        $totalTes            = Questionnaire::where('is_active', true)->count();

        // Metrik antrean konseling
        $waitingCount        = ChatSession::where('type', 'human')->where('status', 'waiting')->count();
        $activeLiveCount     = ChatSession::where('type', 'human')->where('status', 'active')->count();

        $waitingSessions     = ChatSession::where('type', 'human')
                                          ->where('status', 'waiting')
                                          ->with(['user.studentProfile'])
                                          ->orderBy('requested_at', 'asc')
                                          ->take(5)
                                          ->get();

        $recentSessions      = ChatSession::with('user')->latest()->take(6)->get();

        $recentBadEvaluations = ChatEvaluation::where('rating', 'bad')
                                              ->with(['message.session.user', 'evaluator'])
                                              ->latest()
                                              ->take(4)
                                              ->get();

        return view('counselor.dashboard', compact(
            'totalSiswa',
            'totalPercakapan',
            'totalEbook',
            'totalArtikel',
            'totalTes',
            'waitingCount',
            'activeLiveCount',
            'waitingSessions',
            'recentSessions',
            'recentBadEvaluations'
        ));
    }

    /** Daftar siswa — /bk/siswa */
    public function siswa(Request $request)
    {
        $query = User::where('role', 'siswa');
        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->q}%")
                  ->orWhere('email', 'like', "%{$request->q}%");
            });
        }
        $students = $query->latest()->paginate(15);
        return view('counselor.siswa', compact('students'));
    }

    /** Riwayat percakapan semua siswa — /bk/percakapan */
    public function percakapan(Request $request)
    {
        $sessions = ChatSession::with('user')->latest()->paginate(15);
        return view('counselor.percakapan', compact('sessions'));
    }

    /** Detail satu sesi percakapan — /bk/percakapan/{id} */
    public function percakapanDetail(int $id)
    {
        $session  = ChatSession::with(['user', 'messages.evaluations'])->findOrFail($id);
        return view('counselor.percakapan-detail', compact('session'));
    }

    /** Manajemen e-book — /bk/ebook */
    public function ebook()
    {
        $ebooks = Ebook::latest()->paginate(15);
        return view('counselor.ebook', compact('ebooks'));
    }

    /** Simpan e-book baru */
    public function ebookStore(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'file'        => 'required|file|mimes:pdf|max:20480',
            'cover'       => 'nullable|image|max:2048',
            'is_public'   => 'boolean',
        ]);

        $filePath  = $request->file('file')->store('ebooks', 'public');
        $coverPath = $request->hasFile('cover')
            ? $request->file('cover')->store('ebook-covers', 'public')
            : null;

        Ebook::create([
            'title'       => $request->title,
            'description' => $request->description,
            'file_path'   => $filePath,
            'cover_path'  => $coverPath,
            'is_public'   => $request->boolean('is_public'),
            'uploaded_by' => auth()->id(),
        ]);

        return redirect()->route('counselor.ebook')->with('success', 'E-book berhasil ditambahkan.');
    }

    /** Hapus e-book */
    public function ebookDestroy(int $id)
    {
        Ebook::findOrFail($id)->delete();
        return back()->with('success', 'E-book berhasil dihapus.');
    }

    /** Manajemen artikel — /bk/artikel */
    public function artikel(Request $request, \App\Services\ArticleApiService $apiService)
    {
        $articles = Article::latest()->paginate(15);
        
        $searchQuery = (string) ($request->input('q') ?? '');
        $publicArticles = $apiService->fetchPublicArticles($searchQuery, 'all', 1, 6);

        return view('counselor.artikel', compact('articles', 'publicArticles', 'searchQuery'));
    }

    /** Simpan artikel baru */
    public function artikelStore(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'content'      => 'required|string',
            'thumbnail'    => 'nullable|image|max:2048',
            'is_published' => 'boolean',
        ]);

        $thumbnailPath = $request->hasFile('thumbnail')
            ? $request->file('thumbnail')->store('article-thumbnails', 'public')
            : null;

        Article::create([
            'title'        => $request->title,
            'slug'         => \Str::slug($request->title) . '-' . time(),
            'content'      => $request->content,
            'thumbnail'    => $thumbnailPath,
            'is_published' => $request->boolean('is_published', true),
            'author_id'    => auth()->id(),
        ]);

        return redirect()->route('counselor.artikel')->with('success', 'Artikel berhasil ditambahkan.');
    }

    /** Impor artikel dari API Publik (Crossref / OpenAlex) */
    public function artikelImport(Request $request)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'author'   => 'nullable|string',
            'journal'  => 'nullable|string',
            'url'      => 'nullable|url',
            'abstract' => 'nullable|string',
        ]);

        $content = "<p><strong>Penulis:</strong> " . e($request->author) . "</p>";
        $content .= "<p><strong>Penerbit/Jurnal:</strong> " . e($request->journal) . "</p>";
        if ($request->url) {
            $content .= "<p><strong>Link Jurnal Asli:</strong> <a href='" . e($request->url) . "' target='_blank'>" . e($request->url) . "</a></p>";
        }
        $content .= "<hr><p>" . nl2br(e($request->abstract)) . "</p>";

        Article::create([
            'title'        => $request->title,
            'slug'         => \Str::slug($request->title) . '-' . time(),
            'content'      => $content,
            'is_published' => true,
            'author_id'    => auth()->id(),
        ]);

        return redirect()->route('counselor.artikel')->with('success', 'Artikel publik berhasil diimpor ke sistem SAPA BK.');
    }

    /** Hapus artikel */
    public function artikelDestroy(int $id)
    {
        Article::findOrFail($id)->delete();
        return back()->with('success', 'Artikel berhasil dihapus.');
    }

    /** Knowledge base — /bk/knowledge-base */
    public function knowledgeBase()
    {
        $documents = KnowledgeDocument::latest()->paginate(15);
        return view('counselor.knowledge-base', compact('documents'));
    }

    /** Upload dokumen knowledge base */
    public function knowledgeBaseStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file'  => 'required|file|mimes:pdf,docx,txt|max:20480',
        ]);

        $filePath = $request->file('file')->store('knowledge-documents', 'public');

        KnowledgeDocument::create([
            'title'       => $request->title,
            'file_path'   => $filePath,
            'status'      => 'pending',
            'uploaded_by' => auth()->id(),
        ]);

        return back()->with('success', 'Dokumen berhasil diunggah dan sedang diindeks.');
    }

    /** Hapus dokumen */
    public function knowledgeBaseDestroy(int $id)
    {
        KnowledgeDocument::findOrFail($id)->delete();
        return back()->with('success', 'Dokumen berhasil dihapus.');
    }

    /** Manajemen tes — /bk/tes */
    public function tes()
    {
        $questionnaires = Questionnaire::withCount('results')->latest()->paginate(15);
        return view('counselor.tes', compact('questionnaires'));
    }

    /** Hasil tes per kuesioner — /bk/tes/{id}/hasil */
    public function tesHasil(int $id)
    {
        $questionnaire = Questionnaire::with(['results.user'])->findOrFail($id);
        return view('counselor.tes-hasil', compact('questionnaire'));
    }

    /** Evaluasi chatbot — /bk/evaluasi */
    public function evaluasi(Request $request)
    {
        $messages = ChatMessage::where('role', 'assistant')
                               ->with(['session.user', 'evaluations'])
                               ->latest()
                               ->paginate(15);
        return view('counselor.evaluasi', compact('messages'));
    }

    /** Simpan evaluasi chatbot */
    public function evaluasiStore(Request $request)
    {
        $request->validate([
            'message_id' => 'required|exists:chat_messages,id',
            'rating'     => 'required|in:good,bad',
            'note'       => 'nullable|string|max:500',
        ]);

        ChatEvaluation::updateOrCreate(
            ['message_id' => $request->message_id, 'evaluated_by' => auth()->id()],
            ['rating' => $request->rating, 'note' => $request->note]
        );

        return back()->with('success', 'Evaluasi disimpan.');
    }

    /** Manajemen FAQ — /bk/faq */
    public function faq()
    {
        $faqs = Faq::orderBy('order')->get();
        return view('counselor.faq', compact('faqs'));
    }

    /** Simpan FAQ baru */
    public function faqStore(Request $request)
    {
        $request->validate([
            'question'  => 'required|string',
            'answer'    => 'required|string',
            'is_active' => 'boolean',
        ]);

        Faq::create([
            'question'  => $request->question,
            'answer'    => $request->answer,
            'order'     => Faq::max('order') + 1,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return back()->with('success', 'FAQ berhasil ditambahkan.');
    }

    /** Hapus FAQ */
    public function faqDestroy(int $id)
    {
        Faq::findOrFail($id)->delete();
        return back()->with('success', 'FAQ berhasil dihapus.');
    }

    /**
     * Portal Live Chat Konseling Guru BK — /bk/live-chat
     */
    public function liveChat()
    {
        $waitingSessions = ChatSession::where('type', 'human')
                                      ->where('status', 'waiting')
                                      ->with(['user.studentProfile', 'messages'])
                                      ->orderBy('requested_at', 'asc')
                                      ->get();

        $activeSessions = ChatSession::where('type', 'human')
                                     ->where('counselor_id', auth()->id())
                                     ->where('status', 'active')
                                     ->with(['user.studentProfile', 'messages'])
                                     ->latest()
                                     ->get();

        return view('counselor.live-chat', compact('waitingSessions', 'activeSessions'));
    }

    /**
     * API Data Antrean Live Chat — GET /api/bk/live-chat/queue
     */
    public function liveChatQueue()
    {
        $waitingSessions = ChatSession::where('type', 'human')
                                      ->where('status', 'waiting')
                                      ->with(['user.studentProfile', 'messages'])
                                      ->orderBy('requested_at', 'asc')
                                      ->get();

        $activeSessions = ChatSession::where('type', 'human')
                                     ->where('counselor_id', auth()->id())
                                     ->where('status', 'active')
                                     ->with(['user.studentProfile', 'messages'])
                                     ->latest()
                                     ->get();

        return response()->json([
            'waiting' => $waitingSessions,
            'active'  => $activeSessions,
        ]);
    }

    /**
     * Terima Antrean Sesi Siswa — POST /api/bk/live-chat/{id}/accept
     */
    public function liveChatAccept(int $id)
    {
        $session = ChatSession::where('type', 'human')
                               ->where('status', 'waiting')
                               ->findOrFail($id);

        $session->update([
            'counselor_id' => auth()->id(),
            'status'       => 'active',
        ]);

        ChatMessage::create([
            'session_id' => $session->id,
            'role'       => 'system',
            'content'    => 'Guru BK ' . auth()->user()->name . ' telah menerima percakapan dan bergabung ke sesi konseling live.',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Sesi konseling berhasil diterima.',
            'session' => $session->load(['user.studentProfile', 'messages']),
        ]);
    }

    /**
     * Guru BK Kirim Pesan Live Chat — POST /api/bk/live-chat/{id}/send
     */
    public function liveChatSend(Request $request, int $id)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $session = ChatSession::where('type', 'human')
                               ->where('counselor_id', auth()->id())
                               ->where('status', 'active')
                               ->findOrFail($id);

        $message = ChatMessage::create([
            'session_id' => $session->id,
            'role'       => 'counselor',
            'content'    => $request->message,
        ]);

        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }

    /**
     * Akhiri Sesi Live Chat — POST /api/bk/live-chat/{id}/close
     */
    public function liveChatClose(int $id)
    {
        $session = ChatSession::where('type', 'human')
                               ->where('counselor_id', auth()->id())
                               ->findOrFail($id);

        $session->update([
            'status' => 'closed',
        ]);

        ChatMessage::create([
            'session_id' => $session->id,
            'role'       => 'system',
            'content'    => 'Sesi konseling live telah diakhiri oleh Guru BK ' . auth()->user()->name . '.',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Sesi konseling telah diakhiri.',
        ]);
    }
}
