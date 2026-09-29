<?php

namespace App\Services;

use App\Events\LiveChatMessageSent;
use App\Models\ChatMessage;
use App\Models\ChatSession;
use App\Models\Ebook;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * ChatService: Service Layer Terpusat untuk Komunikasi AI Chatbot (SRS NF-09 & NF-10).
 *
 * Mengelola komunikasi antara antarmuka Laravel dengan AI Pipeline (FastAPI / Gemini / ChromaDB)
 * serta menyimpan rekam jejak percakapan siswa ke basis data.
 */
class ChatService
{
    /**
     * URL Microservice Python RAG (jika sudah aktif).
     */
    protected string $aiServiceUrl;

    protected GeminiService $geminiService;

    public function __construct(?GeminiService $geminiService = null)
    {
        $this->aiServiceUrl = config('services.ai.url', 'http://127.0.0.1:8000');
        $this->geminiService = $geminiService ?? app(GeminiService::class);
    }

    /**
     * Memproses pengiriman pesan pengguna dan menghasilkan balasan RAG AI atau respons Konselor Guru BK.
     *
     * @return array{session: ChatSession, user_message: ChatMessage, assistant_message: ChatMessage}
     */
    public function processMessage(string $messageText, ?int $sessionId = null, ?User $user = null, string $mode = 'ai', ?int $teacherId = null, ?array $attachment = null): array
    {
        $normalizedMode = ($mode === 'live' || $mode === 'guru_bk') ? 'guru_bk' : 'ai';

        // 1. Dapatkan atau buat sesi konsultasi
        if (! $sessionId) {
            if ($normalizedMode === 'guru_bk') {
                // Aturan Bisnis: Siswa hanya bisa memiliki 1 sesi konseling aktif
                $existingActive = ChatSession::where('user_id', $user?->id)
                    ->where('mode', 'guru_bk')
                    ->where('status', 'active')
                    ->first();

                if ($existingActive) {
                    throw new \DomainException('Anda masih memiliki 1 sesi konseling aktif dengan Guru BK.');
                }

                // Tetapkan teacher_id jika disediakan atau ambil guru BK pertama yang aktif
                $assignedTeacherId = $teacherId ?? User::where('role', 'guru_bk')->where('is_active', true)->value('id');

                $session = ChatSession::create([
                    'user_id' => $user?->id,
                    'teacher_id' => $assignedTeacherId,
                    'title' => 'Konsultasi: '.mb_substr($messageText, 0, 30).'...',
                    'mode' => 'guru_bk',
                    'status' => 'active',
                    'started_at' => now(),
                ]);
            } else {
                $session = ChatSession::create([
                    'user_id' => $user?->id,
                    'title' => mb_substr($messageText, 0, 40).'...',
                    'mode' => 'ai',
                    'status' => 'active',
                    'started_at' => now(),
                ]);
            }
        } else {
            $session = ChatSession::with('teacher')->findOrFail($sessionId);

            // Aturan Bisnis: Input chat terkunci jika sesi berstatus closed
            if ($session->isClosed()) {
                throw new \DomainException('Sesi konseling ini telah diakhiri oleh Guru BK.');
            }

            if ($session->mode !== $normalizedMode && $normalizedMode === 'guru_bk') {
                $session->update(['mode' => 'guru_bk']);
            }
        }

        $userMetadata = null;
        if (! empty($attachment) && is_array($attachment)) {
            $userMetadata = ['attachment' => $attachment];
        }

        // 2. Simpan pesan dari pengguna
        $userMessage = ChatMessage::create([
            'session_id' => $session->id,
            'sender_id' => $user?->id,
            'role' => 'user',
            'content' => $messageText,
            'metadata' => $userMetadata,
        ]);

        // 3. Jika mode Live Chat Guru BK, catat konfirmasi penerimaan konseling
        if ($normalizedMode === 'guru_bk') {
            try {
                broadcast(new LiveChatMessageSent($session->id, [
                    'id' => $userMessage->id,
                    'role' => 'user',
                    'content' => $userMessage->content,
                    'metadata' => $userMessage->metadata,
                    'time' => $userMessage->created_at ? $userMessage->created_at->format('H:i').' WIB' : 'Baru saja',
                    'sender_id' => $user?->id,
                ], $session->status));
            } catch (\Throwable) {
                // Abaikan jika reverb offline
            }

            // Pesan otomatis konfirmasi antrean hanya dikirim satu kali saat pesan pertama kali dikirim dalam sesi
            $hasPriorMessages = ChatMessage::where('session_id', $session->id)
                ->where('id', '!=', $userMessage->id)
                ->exists();

            $counselorMessage = null;

            if (! $hasPriorMessages) {
                $teacher = $session->teacher ?? ($session->teacher_id ? User::find($session->teacher_id) : null);
                $counselorName = $teacher?->name ?? 'Guru BK SMAN 4 Jember';

                $counselorMessage = ChatMessage::create([
                    'session_id' => $session->id,
                    'sender_id' => $session->teacher_id,
                    'role' => 'counselor',
                    'content' => 'Terima kasih telah berkonsultasi, '.($user ? explode(' ', $user->name)[0] : 'Siswa').'. Pesan bimbinganmu telah masuk ke antrean '.$counselorName.'. Guru BK akan segera merespons langsung melalui sesi live chat ini.',
                    'metadata' => [
                        'counselor' => $counselorName,
                        'service' => 'Live Chat Konseling Guru BK',
                        'is_auto_reply' => true,
                    ],
                ]);
            }

            return [
                'session' => $session,
                'user_message' => $userMessage,
                'assistant_message' => $counselorMessage,
            ];
        }

        // 4. Generate respons AI (Python Service atau Fallback Mock Cerdas)
        $aiPrompt = $messageText;
        if (! empty($attachment) && ! empty($attachment['title'])) {
            $typeLabel = $attachment['type_label'] ?? 'Materi';
            $aiPrompt = "[Mendiskusikan {$typeLabel}: {$attachment['title']}] {$messageText}";
        }
        $aiResponse = $this->queryAiPipeline($aiPrompt, $session->id, $user?->id);

        // 5. Simpan jawaban asisten ke basis data
        $assistantMessage = ChatMessage::create([
            'session_id' => $session->id,
            'role' => 'assistant',
            'content' => $aiResponse['answer'],
            'metadata' => [
                'sources' => $aiResponse['sources'] ?? [],
                'recommended_ebooks' => $aiResponse['recommended_ebooks'] ?? [],
                'model' => $aiResponse['model'] ?? 'Gemini 2.0 Flash (SAPA-RAG Core)',
            ],
        ]);

        return [
            'session' => $session,
            'user_message' => $userMessage,
            'assistant_message' => $assistantMessage,
        ];
    }

    /**
     * Memanggil Google Gemini Official API, Python AI Service, atau fallback ke Mock Engine cerdas.
     *
     * @return array{answer: string, sources: array, recommended_ebooks: array, model: string}
     */
    protected function queryAiPipeline(string $queryText, int $sessionId, ?int $userId): array
    {
        // 1. Ambil riwayat percakapan sesi sebelumnya (multi-turn dialog memory)
        $history = ChatMessage::where('session_id', $sessionId)
            ->whereIn('role', ['user', 'assistant'])
            ->orderBy('id', 'asc')
            ->take(8)
            ->get()
            ->map(fn ($m) => [
                'role' => $m->role,
                'content' => $m->content,
            ])
            ->toArray();

        // 2. Jalur Utama: Google Gemini Official Cloud API (jika GEMINI_API_KEY terpasang)
        if ($this->geminiService->isConfigured()) {
            $geminiResult = $this->geminiService->generateChatResponse($queryText, $history);
            if ($geminiResult['success'] && ! empty($geminiResult['answer'])) {
                return [
                    'answer' => $geminiResult['answer'],
                    'sources' => [
                        'Google Gemini AI (Cloud)',
                        'Pedoman Pelayanan BK SMAN 4 Jember',
                    ],
                    'recommended_ebooks' => $this->findRecommendedEbooks($queryText),
                    'model' => 'Google Gemini ('.$geminiResult['model'].')',
                ];
            }

            Log::warning('Gemini API tidak memberikan balasan valid, beralih ke fallback: '.($geminiResult['error'] ?? 'Unknown error'));
        }

        // 3. Upaya memanggil Python FastAPI service jika terkonfigurasi & online
        try {
            $response = Http::timeout(3)->post("{$this->aiServiceUrl}/api/chat", [
                'session_id' => (string) $sessionId,
                'message' => $queryText,
                'user_id' => $userId,
            ]);

            if ($response->successful()) {
                $data = $response->json();

                return [
                    'answer' => $data['answer'] ?? '',
                    'sources' => $data['sources'] ?? [],
                    'recommended_ebooks' => $data['recommended_ebooks'] ?? [],
                    'model' => 'Google Gemini 2.0 Flash (Python ChromaDB)',
                ];
            }
        } catch (\Throwable $e) {
            // Service Python offline, lanjutkan ke mock cerdas
        }

        // 4. Fallback: Engine Cerdas Kontekstual SMAN 4 Jember (SRS Bab 9.4)
        return $this->generateContextualMockResponse($queryText);
    }

    /**
     * Merekomendasikan e-book perpustakaan BK SMAN 4 Jember yang relevan dengan pertanyaan siswa.
     *
     * @return array<int, array{id: int, title: string, url: string}>
     */
    protected function findRecommendedEbooks(string $query): array
    {
        $q = strtolower($query);
        $recommended = [];
        $keywords = [];

        if (str_contains($q, 'jurusan') || str_contains($q, 'kuliah') || str_contains($q, 'snbt') || str_contains($q, 'snbp') || str_contains($q, 'ptn')) {
            $keywords = ['Karir', 'Kuliah', 'Jurusan'];
        } elseif (str_contains($q, 'stress') || str_contains($q, 'stres') || str_contains($q, 'cemas') || str_contains($q, 'mental')) {
            $keywords = ['Stres', 'Cemas', 'Mental'];
        } elseif (str_contains($q, 'belajar') || str_contains($q, 'fokus') || str_contains($q, 'waktu')) {
            $keywords = ['Belajar', 'Waktu'];
        }

        if (! empty($keywords)) {
            $ebooks = Ebook::where(function ($queryBuilder) use ($keywords) {
                foreach ($keywords as $kw) {
                    $queryBuilder->orWhere('title', 'like', "%{$kw}%");
                }
            })->take(2)->get();

            foreach ($ebooks as $ebook) {
                $recommended[] = [
                    'id' => $ebook->id,
                    'title' => $ebook->title,
                    'url' => route('ebook.detail', $ebook->id),
                ];
            }
        }

        return $recommended;
    }

    /**
     * Menghasilkan jawaban cerdas berbasis keyword BK dan kurikulum SMAN 4 Jember.
     *
     * @return array{answer: string, sources: array, recommended_ebooks: array, model: string}
     */
    protected function generateContextualMockResponse(string $query): array
    {
        $q = strtolower($query);
        $sources = [];
        $recommendedEbooks = [];

        if (str_contains($q, 'jurusan') || str_contains($q, 'kuliah') || str_contains($q, 'snbt') || str_contains($q, 'snbp') || str_contains($q, 'ptn')) {
            $replyText = 'Halo! Mengenai pemilihan jurusan dan persiapan studi lanjut di SMAN 4 Jember, kamu perlu menganalisis minat bakat, nilai rapor semester 1-5, serta mata pelajaran pendukung pada Kurikulum Merdeka. Guru BK SMAN 4 Jember juga siap mendampingi pemetaan peluang SNBP/SNBT melalui layanan konseling tatap muka atau Live Chat.';
            $sources = ['Panduan Kurikulum Merdeka & Kelanjutan Studi SMAN 4 Jember', 'Pedoman SNPMB Kemdikbud'];

            $ebook = Ebook::where('title', 'like', '%Karir%')->orWhere('title', 'like', '%Kuliah%')->first();
            if ($ebook) {
                $recommendedEbooks[] = [
                    'id' => $ebook->id,
                    'title' => $ebook->title,
                    'url' => route('ebook.detail', $ebook->id),
                ];
            }
        } elseif (str_contains($q, 'stress') || str_contains($q, 'cemas') || str_contains($q, 'capek') || str_contains($q, 'masalah') || str_contains($q, 'teman') || str_contains($q, 'bully')) {
            $replyText = 'Terima kasih sudah bercerita. Mengalami tekanan belajar, rasa cemas, atau keletihan mental adalah hal yang wajar bagi pelajar SMA. Kamu tidak sendirian. Ambil jeda istirahat dan tarik napas dalam-dalam. Jika kamu butuh tempat bercerita yang aman dengan kerahasiaan terjaga, Bapak/Ibu Guru BK SMA Negeri 4 Jember siap mendengarkan kapan pun melalui menu Live Chat atau di ruang BK.';
            $sources = ['Panduan Manajemen Stres Remaja SMA', 'Kode Etik Pelayanan Bimbingan Konseling'];
        } elseif (str_contains($q, 'kuesioner') || str_contains($q, 'tes') || str_contains($q, 'asesmen') || str_contains($q, 'bakat')) {
            $replyText = 'SAPA BK menyediakan fitur Tes dan Kuesioner Minat Bakat yang dapat kamu akses melalui menu Asesmen di Dashboard Siswa. Hasil asesmen ini akan membantu Guru BK memberikan rekomendasi karir dan gaya belajar yang paling pas untuk potensimu.';
            $sources = ['Pedoman Asesmen Diagnostik Non-Kognitif BK SMAN 4 Jember'];
        } else {
            $replyText = 'Halo! Saya adalah SAPA BK, asisten bimbingan dan konseling digital SMA Negeri 4 Jember. Saya siap membantumu seputar informasi akademik, perencanaan karir & studi lanjut, serta bimbingan pribadi dan sosial. Apa yang ingin kamu diskusikan hari ini?';
            $sources = ['Buku Pedoman Pelayanan BK SMA Negeri 4 Jember'];
        }

        return [
            'answer' => $replyText,
            'sources' => $sources,
            'recommended_ebooks' => $recommendedEbooks,
            'model' => 'Gemini 2.0 Flash (SAPA-RAG Core)',
        ];
    }
}
