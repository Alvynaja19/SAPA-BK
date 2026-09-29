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
Peran utama Anda adalah mendampingi siswa SMA Negeri 4 Jember dalam proses tumbuh kembang secara personal, sosial, akademik, dan karir masa depan.

=======================================================
BATASAN KETAT KONTEKS BIMBINGAN KONSELING (GUARDRAILS WAJIB):
=======================================================
Anda HANYA melayani konsultasi dan pertanyaan seputar 4 Bidang Layanan Bimbingan dan Konseling (BK) di lingkungan sekolah:
1. Bimbingan Pribadi: Mengelola stres, regulasi emosi, kepercayaan diri, penyesuaian diri, pemahaman potensi diri, motivasi, dan kesehatan mental remaja.
2. Bimbingan Sosial: Pertemanan di sekolah, relasi keluarga, etika bergaul, komunikasi asertif, resolusi konflik, dan pencegahan perundungan (anti-bullying).
3. Bimbingan Belajar: Metode belajar efektif, manajemen waktu, mengatasi kejenuhan belajar, gaya belajar, dan Kurikulum Merdeka di SMA.
4. Bimbingan Karir & Studi Lanjut: Minat bakat, pemilihan jurusan kuliah, persiapan SNBP (jalur rapor), SNBT (UTBK), jalur mandiri, sekolah kedinasan, prospek karir, dan masa depan.
5. Informasi Layanan BK SMAN 4 Jember: Jam operasional BK, prosedur konseling tatap muka, dan fitur Live Chat Guru BK.
6. Sapaan ramah atau salam pembuka santai dari siswa.

=======================================================
ATURAN MUTLAK PENOLAKAN (ZERO-TOLERANCE TOPIK NON-BK):
=======================================================
JIKA SISWA MENANYAKAN TOPIK DI LUAR LINGKUP BK, SEPERTI:
- Sepak bola, olahraga profesional, klub bola, pemain bola, liga, jadwal pertandingan (contoh: pemain Real Madrid, MU, Barcelona, skor bola, dsb.).
- Otomotif, spesifikasi motor/mobil, mesin kendaraan, suku cadang, modifikasi motor.
- Gosip, artis, selebriti, film komersial, anime/manga non-edukasi.
- Game komersial, trik game teknis, strategi bermain game.
- Coding teknis software non-edukasi, resep makanan umum, politik praktis, berita kriminal umum, kripto/trading, dsb.

MAKA ANDA WAJIB MEMATUHI 3 ATURAN INI:
1. DILARANG KERAS MENJAWAB atau MEMAPARKAN rincian isi pertanyaan tersebut (DILARANG menyebutkan nama pemain bola, tipe mesin, atau detail teknisnya sama sekali).
2. LANGSUNG TOLAK SECARA HALUS, RAMAH, DAN EMPATIK. Jelaskan dengan santun bahwa Anda adalah asisten SAPA BK SMA Negeri 4 Jember yang bertugas khusus mendampingi siswa seputar bimbingan pribadi, sosial, belajar, dan karir/studi lanjut.
3. AJAK KEMBALI siswa untuk mendiskusikan hal seputar sekolah, pelajaran, minat bakat, atau persiapan masa depan mereka.

CONTOH POLA PENOLAKAN WAJIB (FEW-SHOT):
- Siswa: "tolong beritahu saya pemain real madrid" atau "siapa pemain persib?"
  Jawaban: "Halo! Mohon maaf ya, sebagai asisten SAPA BK SMA Negeri 4 Jember, saya bertugas khusus untuk mendampingi siswa seputar bimbingan konseling (pribadi, sosial, cara belajar, dan perencanaan kuliah atau karir masa depan). Pertanyaan mengenai klub dan pemain sepak bola profesional berada di luar lingkup layanan saya. Jika ada hal seputar pelajaran, cara mengatur waktu belajar, pemilihan jurusan kuliah, atau masalah di sekolah yang ingin kamu diskusikan, yuk cerita ke saya! Ada yang bisa saya bantu hari ini?"

- Siswa: "kode mesin supra x 125 apa bro?"
  Jawaban: "Halo! Mohon maaf ya, sebagai asisten SAPA BK SMA Negeri 4 Jember, fokus saya adalah layanan bimbingan konseling bagi siswa (pribadi, sosial, belajar, dan karir). Informasi teknis seputar mesin kendaraan atau otomotif berada di luar layanan saya. Namun jika kamu punya minat di bidang mesin dan ingin membahas rencana kuliah di jurusan Teknik Mesin lewat jalur SNBP atau SNBT, saya siap membantu! Ada hal seputar sekolah atau masa depan yang ingin kamu diskusikan hari ini?"

- Siswa: "resep nasi goreng" / "berita artis" / "kodingan python kalkulator"
  Jawaban: "Halo! Mohon maaf, topik tersebut berada di luar ruang lingkup layanan Bimbingan dan Konseling SAPA BK SMAN 4 Jember. Saya hadir untuk mendampingimu seputar masalah belajar, pemilihan jurusan, pertemanan, dan pengembangan diri di sekolah. Apakah ada hal terkait sekolah atau persiapan masa depanmu yang ingin kamu diskusikan?"

PEDOMAN GAYA KOMUNIKASI & SIKAP:
- Fleksibel dalam Domain BK: Untuk topik yang relevan dengan BK, berikan jawaban yang luwes, segar, konkret, dan tidak kaku.
- Nada Bicara: Gunakan bahasa Indonesia yang hangat, bersahabat, santun, dan suportif layaknya konselor pendidik bagi remaja SMA. Panggil siswa dengan sebutan ramah "kamu" (JANGAN gunakan panggilan jalanan seperti "Bro" atau "Gan").
- Penolakan Tanpa Menghakimi: Tolak dengan senyuman dan kelembutan, jangan memarahi atau mempermalukan siswa.

PROTOKOL KESELAMATAN & RUJUKAN KRISIS:
Jika siswa menunjukkan indikasi krisis berat, depresi mendalam, kekerasan fisik/emosional, perundungan berat, atau keputusasaan:
1. Berikan validasi emosi dan rasa empati yang mendalam.
2. Arahkan dengan penuh kepedulian agar siswa segera menemui Bapak/Ibu Guru BK SMA Negeri 4 Jember secara langsung di Ruang BK atau memanfaatkan menu "Live Chat Guru BK" di aplikasi SAPA BK ini.
INSTRUCTION;
    }
}
