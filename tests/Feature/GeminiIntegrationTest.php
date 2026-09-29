<?php

namespace Tests\Feature;

use App\Models\ChatMessage;
use App\Models\ChatSession;
use App\Models\User;
use App\Services\ChatService;
use App\Services\GeminiService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GeminiIntegrationTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_gemini_service_detects_configuration_state(): void
    {
        $unconfiguredService = new GeminiService(apiKey: '');
        $this->assertFalse($unconfiguredService->isConfigured());

        $configuredService = new GeminiService(apiKey: 'AIzaSyFakeApiKeyForTesting12345');
        $this->assertTrue($configuredService->isConfigured());
        $this->assertSame('gemini-3.5-flash-lite', $configuredService->getModel());
    }

    public function test_gemini_service_returns_helpful_message_when_unconfigured(): void
    {
        $service = new GeminiService(apiKey: '');
        $result = $service->testConnection();

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('API Key belum disetel', $result['message']);
    }

    public function test_gemini_service_test_connection_succeeds_when_api_responds(): void
    {
        Http::fake([
            'https://generativelanguage.googleapis.com/*' => Http::response([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [
                                ['text' => 'Aktif.'],
                            ],
                            'role' => 'model',
                        ],
                        'finishReason' => 'STOP',
                    ],
                ],
            ], 200),
        ]);

        $service = new GeminiService(apiKey: 'AIzaSyFakeApiKeyForTesting12345', model: 'gemini-3.5-flash-lite');
        $result = $service->testConnection();

        $this->assertTrue($result['success']);
        $this->assertStringContainsString('Berhasil', $result['message']);
        $this->assertSame('gemini-3.5-flash-lite', $result['model']);
        $this->assertArrayHasKey('latency_ms', $result);
    }

    public function test_gemini_service_generates_chat_response(): void
    {
        Http::fake([
            'https://generativelanguage.googleapis.com/*' => Http::response([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [
                                ['text' => 'Halo! Saya SAPA BK, asisten bimbingan konseling SMAN 4 Jember.'],
                            ],
                            'role' => 'model',
                        ],
                        'finishReason' => 'STOP',
                    ],
                ],
                'modelVersion' => 'gemini-3.5-flash-lite',
            ], 200),
        ]);

        $service = new GeminiService(apiKey: 'AIzaSyFakeApiKeyForTesting12345');
        $result = $service->generateChatResponse('Halo SAPA BK');

        $this->assertTrue($result['success']);
        $this->assertSame('Halo! Saya SAPA BK, asisten bimbingan konseling SMAN 4 Jember.', $result['answer']);
        $this->assertSame('gemini-3.5-flash-lite', $result['model']);
    }

    public function test_admin_can_access_konfigurasi_page_and_run_test_connection(): void
    {
        $admin = User::where('role', 'admin')->where('is_active', true)->first() ?? User::factory()->create(['role' => 'admin', 'is_active' => true]);
        $this->actingAs($admin);

        // Akses halaman konfigurasi
        $response = $this->get('/admin/konfigurasi');
        $response->assertStatus(200);
        $response->assertSee('Google Gemini');
        $response->assertSee('gemini-3.5-flash-lite');

        // Uji endpoint test koneksi ketika API key belum ada
        $testResponse = $this->postJson('/admin/konfigurasi/test');
        $testResponse->assertStatus(200);
        $testData = $testResponse->json();
        $this->assertArrayHasKey('success', $testData);

        // Uji endpoint test koneksi dengan mock berhasil
        Http::fake([
            'https://generativelanguage.googleapis.com/*' => Http::response([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [
                                ['text' => 'Aktif.'],
                            ],
                            'role' => 'model',
                        ],
                    ],
                ],
            ], 200),
        ]);

        $testSuccessResponse = $this->postJson('/admin/konfigurasi/test', [
            'api_key' => 'AIzaSyFakeKey123',
            'model' => 'gemini-3.5-flash-lite',
        ]);
        $testSuccessResponse->assertStatus(200);
        $this->assertTrue($testSuccessResponse->json('success'));
    }

    public function test_chat_service_uses_gemini_when_configured(): void
    {
        Http::fake([
            'https://generativelanguage.googleapis.com/*' => Http::response([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [
                                ['text' => 'Untuk pemilihan jurusan di SMAN 4 Jember, perhatikan nilai rapor dan minat bakat.'],
                            ],
                            'role' => 'model',
                        ],
                    ],
                ],
                'modelVersion' => 'gemini-3.5-flash-lite',
            ], 200),
        ]);

        $geminiService = new GeminiService(apiKey: 'AIzaSyTestingKey123');
        $chatService = new ChatService($geminiService);

        $siswa = User::where('role', 'siswa')->first() ?? User::factory()->create(['role' => 'siswa']);

        $result = $chatService->processMessage(
            messageText: 'Bagaimana cara memilih jurusan kuliah?',
            user: $siswa,
            mode: 'ai'
        );

        $this->assertInstanceOf(ChatSession::class, $result['session']);
        $this->assertInstanceOf(ChatMessage::class, $result['assistant_message']);
        $this->assertSame('Untuk pemilihan jurusan di SMAN 4 Jember, perhatikan nilai rapor dan minat bakat.', $result['assistant_message']->content);
        $this->assertStringContainsString('Google Gemini', $result['assistant_message']->metadata['model']);
    }

    public function test_chat_service_falls_back_gracefully_when_gemini_not_configured(): void
    {
        $geminiService = new GeminiService(apiKey: '');
        $chatService = new ChatService($geminiService);

        $siswa = User::where('role', 'siswa')->first() ?? User::factory()->create(['role' => 'siswa']);

        $result = $chatService->processMessage(
            messageText: 'Saya merasa stres dan cemas menghadapi ujian',
            user: $siswa,
            mode: 'ai'
        );

        $this->assertInstanceOf(ChatMessage::class, $result['assistant_message']);
        $this->assertNotEmpty($result['assistant_message']->content);
        $this->assertStringContainsString('tekanan belajar', $result['assistant_message']->content);
    }

    public function test_chat_service_handles_out_of_scope_questions_gracefully(): void
    {
        Http::fake([
            'https://generativelanguage.googleapis.com/*' => Http::response([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [
                                ['text' => 'Halo! Mohon maaf, topik mesin kendaraan berada di luar lingkup bimbingan konseling SAPA BK SMAN 4 Jember.'],
                            ],
                            'role' => 'model',
                        ],
                    ],
                ],
                'modelVersion' => 'gemini-3.5-flash-lite',
            ], 200),
        ]);

        $geminiService = new GeminiService(apiKey: 'AIzaSyTestingKey123');
        $chatService = new ChatService($geminiService);

        $siswa = User::where('role', 'siswa')->first() ?? User::factory()->create(['role' => 'siswa']);

        $result = $chatService->processMessage(
            messageText: 'kode mesin supra x 125 apa bro?',
            user: $siswa,
            mode: 'ai'
        );

        $this->assertInstanceOf(ChatMessage::class, $result['assistant_message']);
        $this->assertStringContainsString('di luar lingkup', $result['assistant_message']->content);
        // Sources should be empty because it is out of scope refusal
        $this->assertEmpty($result['assistant_message']->metadata['sources']);
    }
}
