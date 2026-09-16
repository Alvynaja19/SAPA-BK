<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use App\Services\RssArticleService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class RssArticleSyncTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_guru_bk_can_sync_rss_articles(): void
    {
        $fakeXml = '<?xml version="1.0" encoding="UTF-8"?>'
            .'<rss version="2.0"><channel><title>Google News</title>'
            .'<item>'
            .'<title>Tips Memilih Jurusan SNBP 2026 - Kompas.com</title>'
            .'<link>https://news.google.com/articles/fake-1</link>'
            .'<pubDate>Mon, 16 Sep 2026 08:00:00 GMT</pubDate>'
            .'<source url="https://kompas.com">Kompas.com</source>'
            .'</item>'
            .'<item>'
            .'<title>Pentingnya Menjaga Kesehatan Mental Remaja - Detik.com</title>'
            .'<link>https://news.google.com/articles/fake-2</link>'
            .'<pubDate>Mon, 16 Sep 2026 09:00:00 GMT</pubDate>'
            .'<source url="https://detik.com">Detik.com</source>'
            .'</item>'
            .'</channel></rss>';

        Http::fake([
            'news.google.com/*' => Http::response($fakeXml, 200, ['Content-Type' => 'application/xml']),
        ]);

        $guru = User::where('role', 'guru_bk')->first() ?? User::factory()->create(['role' => 'guru_bk', 'is_active' => true]);
        $this->actingAs($guru);

        $response = $this->post(route('bk.artikel.sync-rss'), [
            'category' => 'tips_ptn',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('articles', [
            'title' => 'Tips Memilih Jurusan SNBP 2026',
            'category' => 'tips_ptn',
            'source_name' => 'Kompas.com',
            'source_url' => 'https://news.google.com/articles/fake-1',
        ]);

        $article = Article::where('title', 'Tips Memilih Jurusan SNBP 2026')->first();
        $this->assertNotNull($article);
        $this->assertNotEmpty($article->thumbnail);
    }

    public function test_rss_sync_service_skips_duplicates(): void
    {
        $fakeXml = '<?xml version="1.0" encoding="UTF-8"?>'
            .'<rss version="2.0"><channel><title>Google News</title>'
            .'<item>'
            .'<title>Tips Memilih Jurusan SNBP 2026 - Kompas.com</title>'
            .'<link>https://news.google.com/articles/duplicate-link</link>'
            .'<pubDate>Mon, 16 Sep 2026 08:00:00 GMT</pubDate>'
            .'<source url="https://kompas.com">Kompas.com</source>'
            .'</item>'
            .'</channel></rss>';

        Http::fake([
            'news.google.com/*' => Http::response($fakeXml, 200),
        ]);

        $service = new RssArticleService;
        $firstRun = $service->fetchAndSync('tips_ptn', 'test query', 5);
        $this->assertEquals(1, $firstRun['synced']);

        // Second run with same data should be skipped
        $secondRun = $service->fetchAndSync('tips_ptn', 'test query', 5);
        $this->assertEquals(0, $secondRun['synced']);
        $this->assertEquals(1, $secondRun['skipped']);
    }

    public function test_guru_bk_can_filter_articles(): void
    {
        $guru = User::where('role', 'guru_bk')->first() ?? User::factory()->create(['role' => 'guru_bk', 'is_active' => true]);
        $this->actingAs($guru);

        // Buat artikel tes
        $art1 = Article::create([
            'title' => 'Panduan Khusus Sukses Belajar UTBK',
            'slug' => 'panduan-khusus-sukses-belajar-utbk',
            'category' => 'tips_ptn',
            'content' => 'Konten belajar UTBK siswa',
            'is_published' => true,
            'author_id' => $guru->id,
        ]);
        $art1->created_at = '2026-05-10 10:00:00';
        $art1->save();

        $art2 = Article::create([
            'title' => 'Manajemen Emosi dan Self Care Remaja',
            'slug' => 'manajemen-emosi-dan-self-care-remaja',
            'category' => 'kesehatan_mental',
            'content' => 'Konten kesehatan mental',
            'is_published' => true,
            'author_id' => $guru->id,
        ]);
        $art2->created_at = '2026-06-15 10:00:00';
        $art2->save();

        // 1. Filter berdasarkan kata kunci judul
        $responseQ = $this->get(route('bk.artikel', ['q' => 'UTBK']));
        $responseQ->assertOk();
        $responseQ->assertSee('Panduan Khusus Sukses Belajar UTBK');
        $responseQ->assertDontSee('Manajemen Emosi dan Self Care Remaja');

        // 2. Filter berdasarkan kategori
        $responseCat = $this->get(route('bk.artikel', ['category' => 'kesehatan_mental']));
        $responseCat->assertOk();
        $responseCat->assertSee('Manajemen Emosi dan Self Care Remaja');
        $responseCat->assertDontSee('Panduan Khusus Sukses Belajar UTBK');

        // 3. Filter berdasarkan tanggal terbit
        $responseDate = $this->get(route('bk.artikel', ['date' => '2026-05-10']));
        $responseDate->assertOk();
        $responseDate->assertSee('Panduan Khusus Sukses Belajar UTBK');
        $responseDate->assertDontSee('Manajemen Emosi dan Self Care Remaja');
    }
}
