<?php

namespace Tests\Feature;

use App\Models\Ebook;
use App\Models\User;
use App\Services\GoogleBooksService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GoogleBooksIntegrationTest extends TestCase
{
    use RefreshDatabase;

    protected function getStudentUser(): User
    {
        return User::factory()->create([
            'name' => 'Siswa Pembaca Ebook',
            'email' => 'siswa.ebook@sman4jember.sch.id',
            'role' => 'siswa',
            'is_active' => true,
        ]);
    }

    public function test_guest_cannot_access_ebook_apis(): void
    {
        $this->getJson(route('api.ebooks.categories'))->assertStatus(401);
        $this->getJson(route('api.ebooks.search'))->assertStatus(401);
        $this->getJson(route('api.ebooks.detail', ['id' => 'curated-km-01']))->assertStatus(401);
    }

    public function test_authenticated_student_can_fetch_categories(): void
    {
        $student = $this->getStudentUser();
        $this->actingAs($student);

        $response = $this->getJson(route('api.ebooks.categories'));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
        $response->assertJsonStructure([
            'success',
            'categories' => [
                '*' => ['slug', 'name', 'description', 'icon'],
            ],
        ]);
    }

    public function test_search_materi_sma_returns_official_kemdikbud_books(): void
    {
        $student = $this->getStudentUser();
        $this->actingAs($student);

        $response = $this->getJson(route('api.ebooks.search', [
            'category' => 'materi_sma',
        ]));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'source' => 'kemdikbud_sibi',
        ]);
        $this->assertNotEmpty($response->json('books'));
    }

    public function test_search_materi_sma_filters_by_class_level(): void
    {
        $student = $this->getStudentUser();
        $this->actingAs($student);

        $response = $this->getJson(route('api.ebooks.search', [
            'class_level' => 'Kelas X',
        ]));

        $response->assertStatus(200);
        $books = $response->json('books');
        $this->assertNotEmpty($books);

        foreach ($books as $book) {
            $this->assertEquals('Kelas X', $book['class_level']);
        }
    }

    public function test_google_books_service_normalizes_external_api_response(): void
    {
        Http::fake([
            'https://www.googleapis.com/books/v1/volumes*' => Http::response([
                'totalItems' => 1,
                'items' => [
                    [
                        'id' => 'mock_google_id_123',
                        'volumeInfo' => [
                            'title' => 'Psikologi Remaja dan Regulasi Emosi Belajar',
                            'authors' => ['Dr. Ahmad Fauzi, M.Psi'],
                            'publisher' => 'Pustaka Pelajar',
                            'publishedDate' => '2024-05-12',
                            'description' => 'Buku panduan psikologis untuk mengatasi kecemasan siswa.',
                            'imageLinks' => [
                                'thumbnail' => 'http://books.google.com/books/content?id=mock_google_id_123&printsec=frontcover',
                            ],
                            'pageCount' => 180,
                            'language' => 'id',
                            'categories' => ['Psychology / Adolescent'],
                            'previewLink' => 'https://books.google.co.id/books?id=mock_google_id_123',
                        ],
                        'accessInfo' => [
                            'embeddable' => true,
                        ],
                    ],
                ],
            ], 200),
        ]);

        Cache::flush();

        $service = new GoogleBooksService;
        $result = $service->search('psikologi remaja');

        $this->assertTrue($result['success']);
        $this->assertEquals('google_books', $result['source']);
        $this->assertNotEmpty($result['books']);

        $book = $result['books'][0];
        $this->assertEquals('mock_google_id_123', $book['id']);
        $this->assertEquals('Psikologi Remaja dan Regulasi Emosi Belajar', $book['title']);
        $this->assertStringStartsWith('https://', $book['cover_url']);
        $this->assertEquals('google_embed', $book['reader_type']);
        $this->assertTrue($book['embeddable']);
    }

    public function test_google_books_service_falls_back_gracefully_when_quota_limit_429(): void
    {
        Http::fake([
            'https://www.googleapis.com/books/v1/volumes*' => Http::response([
                'error' => [
                    'code' => 429,
                    'message' => 'Quota exceeded',
                    'status' => 'RESOURCE_EXHAUSTED',
                ],
            ], 429),
        ]);

        Cache::flush();

        $service = new GoogleBooksService;
        $result = $service->search('stres');

        // Harus tetap sukses dengan mengembalikan data dari curated_fallback
        $this->assertTrue($result['success']);
        $this->assertEquals('curated_fallback', $result['source']);
        $this->assertNotEmpty($result['books']);
    }

    public function test_detail_endpoint_returns_book_metadata(): void
    {
        $student = $this->getStudentUser();
        $this->actingAs($student);

        $response = $this->getJson(route('api.ebooks.detail', ['id' => 'curated-km-01']));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'book' => [
                'id' => 'curated-km-01',
                'title' => 'Panduan Pengelolaan Stres dan Regulasi Emosi Siswa SMA',
            ],
        ]);
    }

    public function test_student_can_render_ebook_portal_page(): void
    {
        $student = $this->getStudentUser();
        $this->actingAs($student);

        $response = $this->get(route('siswa.ebook'));

        $response->assertStatus(200);
        $response->assertSee('Perpustakaan E-Book &amp; Modul Siswa', false);
        $response->assertSee('ebookSearchInput');
        $response->assertSee('ebookReaderModal');
        $response->assertSee('readerInternalPanel');
        $response->assertSee('readerShowcasePanel');
        $response->assertSee('Semua Koleksi');
        $response->assertSee('Materi Belajar SMA');
        $response->assertSee('Kesehatan Mental &amp; Remaja', false);
    }

    public function test_student_can_stream_internal_pdf(): void
    {
        $student = $this->getStudentUser();
        $this->actingAs($student);

        $ebook = Ebook::create([
            'title' => 'Modul Bimbingan Karir Khusus',
            'description' => 'Panduan karir bagi siswa SMA',
            'file_path' => 'ebooks/eksplorasi_karir.pdf',
            'is_public' => true,
            'uploaded_by' => $student->id,
        ]);

        $response = $this->get(route('ebook.stream', $ebook->id));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
    }

    public function test_stream_generates_pdf_when_physical_file_is_missing(): void
    {
        $student = $this->getStudentUser();
        $this->actingAs($student);

        $ebook = Ebook::create([
            'title' => 'Modul Yang Belum Diunggah Fisik',
            'description' => 'Deskripsi modul darurat',
            'file_path' => 'ebooks/modul_belum_ada_'.uniqid().'.pdf',
            'is_public' => false,
            'uploaded_by' => $student->id,
        ]);

        $response = $this->get(route('ebook.stream', $ebook->id));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
    }
}
