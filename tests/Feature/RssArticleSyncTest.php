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

        $guru = User::where('role', 'guru_bk')->first();
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
}
