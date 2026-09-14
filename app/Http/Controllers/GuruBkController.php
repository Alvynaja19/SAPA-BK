<?php

namespace App\Http\Controllers;

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
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class GuruBkController extends Controller
{
    public function dashboard(): View
    {
        $totalSiswa = User::where('role', 'siswa')->count();
        $totalPercakapan = ChatSession::count();
        $totalEbook = Ebook::count();
        $totalArtikel = Article::count();
        $recentPercakapan = ChatSession::with('user')->latest()->take(6)->get();
        $pendingEvaluations = ChatMessage::where('role', 'assistant')->doesntHave('evaluation')->latest()->take(5)->get();

        return view('bk.dashboard', compact(
            'totalSiswa',
            'totalPercakapan',
            'totalEbook',
            'totalArtikel',
            'recentPercakapan',
            'pendingEvaluations'
        ));
    }

    public function siswa(): View
    {
        $siswa = User::where('role', 'siswa')->latest()->paginate(15);

        return view('bk.siswa', compact('siswa'));
    }

    public function percakapan(): View
    {
        $sessions = ChatSession::with(['user', 'messages'])->latest()->paginate(15);

        return view('bk.percakapan', compact('sessions'));
    }

    public function detailPercakapan(int $id): View
    {
        $session = ChatSession::with(['user', 'messages.evaluation'])->findOrFail($id);

        return view('bk.percakapan-detail', compact('session'));
    }

    public function liveChat(): View
    {
        $siswaList = User::where('role', 'siswa')->take(10)->get();

        return view('bk.live-chat', compact('siswaList'));
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

    public function artikel(): View
    {
        $articles = Article::with('author')->latest()->paginate(10);

        return view('bk.artikel', compact('articles'));
    }

    public function simpanArtikel(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_published' => 'boolean',
        ]);

        Article::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']).'-'.Str::random(5),
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
