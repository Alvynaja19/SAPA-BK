<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * GeminiService: Integrasi Langsung ke Google Gemini REST API (SRS F-52).
 *
 * Mengelola komunikasi langsung dari Laravel ke endpoint Google AI Studio
 * tanpa perantara eksternal jika API key telah disediakan.
 */
class GeminiService
{
    protected ?string $apiKey;

    protected string $model;

    protected float $temperature;

    protected int $maxTokens;

    public function __construct(
        ?string $apiKey = null,
        ?string $model = null,
        ?float $temperature = null,
        ?int $maxTokens = null
    ) {
        $this->apiKey = $apiKey ?? config('services.gemini.api_key', env('GEMINI_API_KEY'));
        $this->model = $model ?? config('services.gemini.model', env('GEMINI_MODEL', 'gemini-3.5-flash-lite'));
        $this->temperature = $temperature ?? (float) config('services.gemini.temperature', env('GEMINI_TEMPERATURE', 0.7));
        $this->maxTokens = $maxTokens ?? (int) config('services.gemini.max_tokens', env('GEMINI_MAX_TOKENS', 2048));
    }

    /**
     * Memeriksa apakah API Key Google Gemini sudah terpasang.
     */
    public function isConfigured(): bool
    {
        return ! empty($this->apiKey) && trim($this->apiKey) !== '';
    }

    public function getApiKey(): ?string
    {
        return $this->apiKey;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    /**
     * Menghasilkan respons percakapan melalui Google Gemini API.
     *
     * @param  array<int, array{role: string, content: string}>  $history
     * @return array{success: bool, answer: ?string, model: string, error?: string, usage?: array}
     */
    public function generateChatResponse(string $message, array $history = [], ?string $systemInstruction = null): array
    {
        if (! $this->isConfigured()) {
            return [
                'success' => false,
                'answer' => null,
                'model' => $this->model,
                'error' => 'GEMINI_API_KEY belum dikonfigurasi di file .env',
            ];
        }

        $instruction = $systemInstruction ?? $this->getDefaultSystemInstruction();
        $contents = $this->buildContentsPayload($history, $message);

        $payload = [
            'contents' => $contents,
            'systemInstruction' => [
                'parts' => [
                    ['text' => $instruction],
                ],
            ],
            'generationConfig' => [
                'temperature' => $this->temperature,
                'maxOutputTokens' => $this->maxTokens,
            ],
        ];

        // Daftar model yang dicoba (prioritaskan model pilihan, fallback ke model aktif lain jika sibuk/deprecate)
        $modelsToTry = array_unique(array_filter([
            $this->model,
            'gemini-3.5-flash-lite',
            'gemini-3.7-flash',
            'gemini-3.8-flash',
        ]));

        $lastError = 'Gagal menghubungi Gemini API';

        foreach ($modelsToTry as $currentModel) {
            try {
                $endpoint = "https://generativelanguage.googleapis.com/v1beta/models/{$currentModel}:generateContent?key={$this->apiKey}";

                $response = Http::timeout(25)
                    ->withHeaders([
                        'Content-Type' => 'application/json',
                    ])
                    ->post($endpoint, $payload);

                if ($response->successful()) {
                    $data = $response->json();
                    $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;

                    if (! empty($text)) {
                        return [
                            'success' => true,
                            'answer' => trim($text),
                            'model' => $data['modelVersion'] ?? $currentModel,
                            'usage' => $data['usageMetadata'] ?? [],
                        ];
                    }

                    $finishReason = $data['candidates'][0]['finishReason'] ?? 'UNKNOWN';
                    $lastError = "Respons Gemini kosong. Status pemutusan: {$finishReason}";

                    continue;
                }

                $errorData = $response->json();
                $lastError = $errorData['error']['message'] ?? $response->body();
                Log::warning("Gemini model {$currentModel} gagal ({$lastError}), mencoba model alternatif...");

                // Jika error adalah API key tidak valid, tidak perlu coba model lain
                if (str_contains($lastError, 'API key not valid') || str_contains($lastError, 'API_KEY_INVALID')) {
                    break;
                }
            } catch (\Throwable $e) {
                $lastError = $e->getMessage();
                Log::warning("Gemini model {$currentModel} exception ({$lastError}), mencoba model alternatif...");
            }
        }

        Log::error('Gemini API Error: '.$lastError);

        return [
            'success' => false,
            'answer' => null,
            'model' => $this->model,
            'error' => $lastError,
        ];
    }

    /**
     * Menguji konektivitas ke Google Gemini API secara nyata.
     *
     * @return array{success: bool, message: string, latency_ms?: int, model?: string}
     */
    public function testConnection(?string $testApiKey = null, ?string $testModel = null): array
    {
        $apiKey = $testApiKey ?: $this->apiKey;
        $requestedModel = $testModel ?: $this->model;

        if (empty($apiKey) || trim($apiKey) === '') {
            return [
                'success' => false,
                'message' => 'API Key belum disetel. Silakan tambahkan GEMINI_API_KEY di file .env terlebih dahulu.',
            ];
        }

        $modelsToTry = array_unique(array_filter([
            $requestedModel,
            'gemini-3.5-flash-lite',
            'gemini-3.7-flash',
            'gemini-3.8-flash',
        ]));

        $lastError = 'Koneksi gagal.';
        $latencyMs = 0;

        foreach ($modelsToTry as $currentModel) {
            $endpoint = "https://generativelanguage.googleapis.com/v1beta/models/{$currentModel}:generateContent?key={$apiKey}";
            $testPayload = [
                'contents' => [
                    [
                        'role' => 'user',
                        'parts' => [
                            ['text' => 'Ping. Jawab hanya satu kata: Aktif.'],
                        ],
                    ],
                ],
                'generationConfig' => [
                    'maxOutputTokens' => 10,
                    'temperature' => 0.1,
                ],
            ];

            $startTime = microtime(true);

            try {
                $response = Http::timeout(10)
                    ->withHeaders(['Content-Type' => 'application/json'])
                    ->post($endpoint, $testPayload);

                $latencyMs = (int) round((microtime(true) - $startTime) * 1000);

                if ($response->successful()) {
                    $note = ($currentModel !== $requestedModel) ? " (Otomatis dialihkan ke {$currentModel})" : '';

                    return [
                        'success' => true,
                        'message' => "Koneksi Google Gemini ({$currentModel}) Berhasil! API Key valid dan merespons dalam {$latencyMs}ms{$note}.",
                        'latency_ms' => $latencyMs,
                        'model' => $currentModel,
                    ];
                }

                $errorData = $response->json();
                $lastError = $errorData['error']['message'] ?? $response->body();

                if (str_contains($lastError, 'API key not valid') || str_contains($lastError, 'API_KEY_INVALID')) {
                    break;
                }
            } catch (\Throwable $e) {
                $latencyMs = (int) round((microtime(true) - $startTime) * 1000);
                $lastError = $e->getMessage();
            }
        }

        return [
            'success' => false,
            'message' => "Gagal terhubung ke Google Gemini: {$lastError}",
            'latency_ms' => $latencyMs,
            'model' => $requestedModel,
        ];
    }

    /**
     * Membangun array payload konten dialog untuk format Google Gemini API.
     *
     * @param  array<int, array{role: string, content: string}>  $history
     * @return array<int, array{role: string, parts: array<int, array{text: string}>}>
     */
    protected function buildContentsPayload(array $history, string $newMessage): array
    {
        $contents = [];

        foreach ($history as $item) {
            $role = ($item['role'] === 'user') ? 'user' : 'model';
            $text = trim((string) ($item['content'] ?? ''));

            if ($text === '') {
                continue;
            }

            // Google Gemini API mewajibkan urutan bergantian dan diawali oleh user
            if (empty($contents) && $role !== 'user') {
                continue;
            }

            $lastRole = ! empty($contents) ? $contents[count($contents) - 1]['role'] : null;
            if ($lastRole === $role) {
                // Gabungkan jika ada dua pesan berturut-turut dengan role yang sama
                $lastIdx = count($contents) - 1;
                $contents[$lastIdx]['parts'][0]['text'] .= "\n".$text;
            } else {
                $contents[] = [
                    'role' => $role,
                    'parts' => [
                        ['text' => $text],
                    ],
                ];
            }
        }

        // Tambahkan pesan pengguna saat ini
        if (! empty($contents) && $contents[count($contents) - 1]['role'] === 'user') {
            $lastIdx = count($contents) - 1;
            $contents[$lastIdx]['parts'][0]['text'] .= "\n".$newMessage;
        } else {
            $contents[] = [
                'role' => 'user',
                'parts' => [
                    ['text' => $newMessage],
                ],
            ];
        }

        return $contents;
    }

    /**
     * Prompt sistem standar untuk peran SAPA BK di SMA Negeri 4 Jember.
     */
    protected function getDefaultSystemInstruction(): string
    {
        return <<<'INSTRUCTION'
Anda adalah SAPA BK, asisten bimbingan dan konseling digital resmi di SMA Negeri 4 Jember (SAPA-BK: Sahabat Siswa Bimbingan dan Konseling).
Peran utama Anda adalah mendampingi siswa SMA Negeri 4 Jember dalam proses tumbuh kembang secara personal, sosial, akademik, dan karir.

Ruang Lingkup 4 Bidang Pelayanan BK:
1. Bimbingan Pribadi: Mengelola stres, regulasi emosi, kepercayaan diri, penyesuaian diri, dan pemahaman potensi diri.
2. Bimbingan Sosial: Membangun komunikasi yang sehat dengan teman sebaya, keluarga, guru, pencegahan perundungan (bullying), serta etika bersosialisasi.
3. Bimbingan Belajar: Metode belajar efektif, manajemen waktu, mengatasi kejenuhan belajar, serta adaptasi Kurikulum Merdeka di SMA.
4. Bimbingan Karir & Kelanjutan Studi: Eksplorasi minat bakat, pemilihan jurusan kuliah, persiapan SNBP (jalur prestasi rapor), SNBT (UTBK), jalur mandiri, sekolah kedinasan, dan perencanaan masa depan.

Pedoman Sikap & Komunikasi:
- Fleksibilitas Penuh: Pertanyaan siswa sangat beragam, tidak terduga, dan unik. Tanggapi setiap pertanyaan secara spesifik, luwes, segar, dan langsung relevan dengan apa pun yang diutarakan siswa (baik tentang akademik, pertemanan, ekstrakurikuler, motivasi, hobi, hingga percakapan santai).
- Hindari Keterpakuan: DILARANG menggunakan jawaban kaku, berulang, atau template seperti naskah hardcoded. Setiap sesi harus terasa hidup, personal, dan mengalir layaknya berbicara dengan konselor manusia yang cerdas dan penuh perhatian.
- Berbahasalah Indonesia dengan nada yang hangat, santun, empatik, objektif, dan suportif khas konselor pendidik bagi remaja SMA.
- Berikan saran yang konkret, mudah diaplikasikan, dan terstruktur jika siswa membutuhkan solusi.
- Jika siswa hanya menyapa atau berbincang santai, sambut dengan ramah dan tanyakan kabar atau hal yang ingin mereka bagi hari ini.
- Jangan pernah menghakimi, menyalahkan, atau merendahkan perasaan siswa.
- Tetap junjung tinggi privasi siswa.

PENTING (Protokol Keselamatan & Rujukan):
Jika siswa menunjukkan indikasi krisis berat, depresi mendalam, kekerasan fisik/emosional, perundungan berat, atau keputusasaan:
1. Berikan validasi emosi dan rasa empati yang mendalam.
2. Anjurkan dengan hangat dan penuh kepedulian agar siswa segera menemui Bapak/Ibu Guru BK SMA Negeri 4 Jember secara langsung di Ruang BK atau memulai sesi tatap muka digital melalui menu "Live Chat Guru BK" di SAPA BK.
INSTRUCTION;
    }
}
