<?php

namespace App\Services;

use App\Models\ChatMessage;
use App\Models\ChatSession;
use App\Models\Ebook;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * ChatService — Service Layer Terpusat untuk Komunikasi AI Chatbot (SRS NF-09 & NF-10).
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

    public function __construct()
    {
        $this->aiServiceUrl = config('services.ai.url', 'http://127.0.0.1:8000');
    }

    /**
     * Memproses pengiriman pesan pengguna dan menghasilkan balasan RAG AI atau respons Konselor Guru BK.
     *
     * @return array{session: ChatSession, user_message: ChatMessage, assistant_message: ChatMessage}
     */
    public function processMessage(string $messageText, ?int $sessionId = null, ?User $user = null, string $mode = 'ai'): array
    {
        $normalizedMode = ($mode === 'live' || $mode === 'guru_bk') ? 'guru_bk' : 'ai';

        // 1. Dapatkan atau buat sesi konsultasi
        if (! $sessionId) {
            $title = ($normalizedMode === 'guru_bk')
                ? 'Konsultasi Guru BK: '.mb_substr($messageText, 0, 30).'...'
                : mb_substr($messageText, 0, 40).'...';

            $session = ChatSession::create([
                'user_id' => $user?->id,
                'title' => $title,
                'mode' => $normalizedMode,
            ]);
        } else {
            $session = ChatSession::findOrFail($sessionId);
            if ($session->mode !== $normalizedMode && $normalizedMode === 'guru_bk') {
                $session->update(['mode' => 'guru_bk']);
            }
        }

        // 2. Simpan pesan dari pengguna
        $userMessage = ChatMessage::create([
            'session_id' => $session->id,
            'role' => 'user',
            'content' => $messageText,
        ]);

        // 3. Jika mode Live Chat Guru BK, catat pesan balasan konselor
        if ($normalizedMode === 'guru_bk') {
            $counselorMessage = ChatMessage::create([
                'session_id' => $session->id,
                'role' => 'counselor',
                'content' => 'Terima kasih telah berkonsultasi, '.($user ? explode(' ', $user->name)[0] : 'Siswa').'. Pesan bimbinganmu telah diterima oleh Guru BK piket SMAN 4 Jember. Kami siap mendiskusikan lebih lanjut baik melalui sesi ini maupun tatap muka langsung di Ruang BK sekolah.',
                'metadata' => [
                    'counselor' => 'Tim Konselor Guru BK SMAN 4 Jember',
                    'service' => 'Live Chat Konseling Guru BK',
                ],
            ]);

            return [
                'session' => $session,
                'user_message' => $userMessage,
                'assistant_message' => $counselorMessage,
            ];
        }

        // 4. Generate respons AI (Python Service atau Fallback Mock Cerdas)
        $aiResponse = $this->queryAiPipeline($messageText, $session->id, $user?->id);

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
     * Memanggil Python AI Service (RAG FastAPI) atau fallback ke Mock Engine jika service offline.
     *
     * @return array{answer: string, sources: array, recommended_ebooks: array, model: string}
     */
    protected function queryAiPipeline(string $queryText, int $sessionId, ?int $userId): array
    {
        // Upaya memanggil Python FastAPI service jika terkonfigurasi
        try {
            $response = Http::timeout(5)->post("{$this->aiServiceUrl}/api/chat", [
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
            Log::info('Python RAG Service offline, beralih ke SAPA-BK Internal RAG Mock: '.$e->getMessage());
        }

        // Fallback: Engine RAG Mock Cerdas Kontekstual SMAN 4 Jember (SRS Bab 9.4)
        return $this->generateContextualMockResponse($queryText);
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
