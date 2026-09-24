<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\CuratedEbookCatalog;
use App\Services\OpenLibraryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class HybridEbookIntegrationTest extends TestCase
{
    use RefreshDatabase;

    protected function getStudentUser(): User
    {
        return User::factory()->create([
            'name' => 'Siswa Pembaca Hybrid Ebook',
            'email' => 'siswa.hybrid@sman4jember.sch.id',
            'role' => 'siswa',
            'is_active' => true,
        ]);
    }

    public function test_curated_catalog_contains_kemenkes_and_unicef_modules(): void
    {
        $kemenkesBooks = CuratedEbookCatalog::kemenkesUnicefBooks();

        $this->assertNotEmpty($kemenkesBooks);
        $this->assertGreaterThanOrEqual(3, count($kemenkesBooks));

        $titles = array_column($kemenkesBooks, 'title');
        $this->assertTrue(
            collect($titles)->contains(fn ($t) => str_contains($t, 'Roots Indonesia') || str_contains($t, 'Kesehatan Jiwa Remaja')),
            'Katalog harus memuat modul Roots Indonesia atau Kesehatan Jiwa Remaja'
        );
    }

    public function test_categories_api_includes_kemenkes_unicef_and_open_library(): void
    {
        $student = $this->getStudentUser();
        $this->actingAs($student);

        $response = $this->getJson(route('api.ebooks.categories'));

        $response->assertStatus(200);
        $slugs = collect($response->json('categories'))->pluck('slug')->all();

        $this->assertContains('kemenkes_unicef', $slugs);
        $this->assertContains('open_library', $slugs);
        $this->assertContains('kesehatan_mental', $slugs);
        $this->assertContains('materi_sma', $slugs);
    }

    public function test_search_source_kemenkes_unicef_returns_curated_official_modules(): void
    {
        $student = $this->getStudentUser();
        $this->actingAs($student);

        $response = $this->getJson(route('api.ebooks.search', [
            'source' => 'kemenkes_unicef',
        ]));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'source' => 'kemenkes_unicef',
        ]);

        $books = $response->json('books');
        $this->assertNotEmpty($books);
        $this->assertArrayHasKey('id', $books[0]);
        $this->assertArrayHasKey('title', $books[0]);
    }

    public function test_open_library_service_normalizes_book_docs_correctly(): void
    {
        Http::fake([
            'https://openlibrary.org/search.json*' => Http::response([
                'num_found' => 1,
                'docs' => [
                    [
                        'key' => '/works/OL99999W',
                        'title' => 'Adolescent Psychology & Mental Health',
                        'author_name' => ['Dr. Sarah Jenkins'],
                        'first_publish_year' => 2021,
                        'cover_i' => 123456,
                        'publisher' => ['Academic Press'],
                        'number_of_pages_median' => 320,
                        'language' => ['eng'],
                        'ia' => ['adolescentpsych0000jenk'],
                        'subject' => ['Adolescent psychology', 'Mental Health'],
                    ],
                ],
            ], 200),
        ]);

        $service = new OpenLibraryService;
        $result = $service->search('adolescent psychology', 5);

        $this->assertTrue($result['success']);
        $this->assertCount(1, $result['books']);

        $book = $result['books'][0];
        $this->assertEquals('ol-OL99999W', $book['id']);
        $this->assertEquals('Adolescent Psychology & Mental Health', $book['title']);
        $this->assertEquals(['Dr. Sarah Jenkins'], $book['authors']);
        $this->assertEquals('archive_embed', $book['reader_type']);
        $this->assertEquals('https://archive.org/embed/adolescentpsych0000jenk', $book['reader_url']);
        $this->assertEquals('Open Library', $book['source']);
    }

    public function test_search_source_open_library_via_api(): void
    {
        Http::fake([
            'https://openlibrary.org/search.json*' => Http::response([
                'num_found' => 2,
                'docs' => [
                    [
                        'key' => '/works/OL111W',
                        'title' => 'Mindfulness for Students',
                        'author_name' => ['John Doe'],
                        'first_publish_year' => 2022,
                        'cover_i' => 999111,
                        'publisher' => ['Global Press'],
                        'number_of_pages_median' => 210,
                        'ia' => [],
                    ],
                ],
            ], 200),
        ]);

        $student = $this->getStudentUser();
        $this->actingAs($student);

        $response = $this->getJson(route('api.ebooks.search', [
            'source' => 'open_library',
            'q' => 'mindfulness',
        ]));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'source' => 'open_library',
        ]);
        $this->assertNotEmpty($response->json('books'));
        $this->assertEquals('ol-OL111W', $response->json('books.0.id'));
    }

    public function test_detail_endpoint_resolves_kemenkes_and_open_library_books(): void
    {
        $student = $this->getStudentUser();
        $this->actingAs($student);

        // 1. Kemenkes curated book detail
        $curatedResponse = $this->getJson(route('api.ebooks.detail', ['id' => 'curated-km-roots']));
        $curatedResponse->assertStatus(200);
        $curatedResponse->assertJson([
            'success' => true,
            'book' => [
                'id' => 'curated-km-roots',
            ],
        ]);

        // 2. Open Library book detail
        Http::fake([
            'https://openlibrary.org/works/OL888W.json' => Http::response([
                'title' => 'The Resilient Student',
                'description' => 'A guide to mental wellness in school.',
                'covers' => [555444],
            ], 200),
        ]);

        $olResponse = $this->getJson(route('api.ebooks.detail', ['id' => 'ol-OL888W']));
        $olResponse->assertStatus(200);
        $olResponse->assertJson([
            'success' => true,
            'book' => [
                'id' => 'ol-OL888W',
                'title' => 'The Resilient Student',
                'source' => 'Open Library',
            ],
        ]);
    }
}
