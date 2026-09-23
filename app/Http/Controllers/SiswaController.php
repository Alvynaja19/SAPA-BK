<?php

namespace App\Http\Controllers;

use App\Models\ChatSession;
use App\Models\Ebook;
use App\Models\Questionnaire;
use App\Models\QuestionnaireResult;
use App\Models\User;
use App\Services\CuratedEbookCatalog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
        $allInternal = Ebook::latest()->get();
        $internalEbooks = $allInternal->map(function (Ebook $eb) {
            return [
                'id' => 'internal-'.$eb->id,
                'title' => $eb->title,
                'authors' => ['Tim Guru BK SMAN 4 Jember'],
                'publisher' => 'SMAN 4 Jember',
                'category' => 'modul_internal',
                'subject' => 'Bimbingan Konseling Sekolah',
                'class_level' => null,
                'description' => $eb->description ?? 'Modul pembelajaran bimbingan konseling untuk pengayaan akademik dan kesiapan karir siswa SMAN 4 Jember.',
                'cover_url' => $eb->cover_path ? Storage::url($eb->cover_path) : null,
                'page_count' => null,
                'published_year' => $eb->created_at ? $eb->created_at->format('Y') : date('Y'),
                'is_curated' => false,
                'is_internal' => true,
                'is_public' => (bool) $eb->is_public,
                'reader_type' => 'in_app',
                'reader_url' => route('ebook.stream', $eb->id),
                'download_url' => route('ebook.download', $eb->id),
                'real_id' => $eb->id,
                'source' => 'Guru BK SMAN 4 Jember',
                'language' => 'Indonesia',
                'badges' => [$eb->is_public ? 'Akses Terbuka' : 'Eksklusif SMAN 4', 'Modul Guru BK'],
            ];
        })->values()->all();

        $curatedBooks = CuratedEbookCatalog::all();

        $stats = [
            'total_all' => count($curatedBooks) + count($internalEbooks),
            'total_mental_health' => count(CuratedEbookCatalog::mentalHealthBooks()),
            'total_materi_sma' => count(CuratedEbookCatalog::smaStudyBooks()),
            'total_internal' => count($internalEbooks),
        ];

        $ebooks = Ebook::latest()->paginate(12);

        return view('siswa.ebook', compact('internalEbooks', 'curatedBooks', 'stats', 'ebooks'));
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

        $title = $ebook->title ?? 'Modul Bimbingan Konseling';
        $desc = $ebook->description ?? 'Modul bimbingan dan materi pengayaan siswa SMA Negeri 4 Jember.';

        $content = "%PDF-1.4\n";
        $content .= "1 0 obj << /Type /Catalog /Pages 2 0 R >> endobj\n";
        $content .= "2 0 obj << /Type /Pages /Kids [3 0 R] /Count 1 >> endobj\n";
        $content .= "3 0 obj << /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Contents 4 0 R /Resources << /Font << /F1 5 0 R >> >> >> endobj\n";

        $stream = 'BT /F1 18 Tf 50 720 Td ('.addcslashes($title, "()\n\r").") Tj ET\n";
        $stream .= "BT /F1 12 Tf 50 690 Td (SAPA BK - SMA Negeri 4 Jember) Tj ET\n";
        $stream .= "BT /F1 10 Tf 50 660 Td (Penyusun: Tim Guru Bimbingan Konseling SMAN 4 Jember) Tj ET\n";
        $stream .= 'BT /F1 10 Tf 50 630 Td ('.addcslashes(substr($desc, 0, 150), "()\n\r").") Tj ET\n";
        $stream .= "BT /F1 9 Tf 50 590 Td (Dokumen digital ini resmi diterbitkan untuk menunjang kegiatan belajar dan konseling siswa.) Tj ET\n";
        $stream .= "BT /F1 9 Tf 50 570 Td (Silakan hubungi Guru BK melalui layanan Chat Konseling jika Anda membutuhkan materi bimbingan lengkap.) Tj ET\n";

        $content .= '4 0 obj << /Length '.strlen($stream)." >> stream\n".$stream."endstream endobj\n";
        $content .= "5 0 obj << /Type /Font /Subtype /Type1 /BaseFont /Helvetica >> endobj\n";

        $xrefPos = strlen($content);
        $content .= "xref\n0 6\n";
        $content .= "0000000000 65535 f \n";
        $content .= "0000000009 00000 n \n";
        $content .= "0000000058 00000 n \n";
        $content .= "0000000115 00000 n \n";
        $content .= "0000000232 00000 n \n";
        $content .= sprintf("%010d 00000 n \n", $xrefPos - 60);
        $content .= "trailer << /Size 6 /Root 1 0 R >>\nstartxref\n".$xrefPos."\n%%EOF";

        @file_put_contents($destPath, $content);

        return file_exists($destPath) ? $destPath : null;
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
}
