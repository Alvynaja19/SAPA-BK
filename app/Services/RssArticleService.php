<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class RssArticleService
{
    /**
     * Sinkronkan artikel berdasarkan topik.
     *
     * @return array{category: string, synced: int, skipped: int, total_fetched: int}
     */
    public function syncByCategory(string $category, int $limit = 5, ?int $authorId = null): array
    {
        $query = match ($category) {
            'tips_ptn' => 'tips lolos PTN SNBP SNBT siswa',
            'kesehatan_mental' => 'kesehatan mental remaja siswa',
            default => 'edukasi bimbingan konseling siswa sma',
        };

        return $this->fetchAndSync($category, $query, $limit, $authorId);
    }

    /**
     * Tarik feed dari Google News RSS dan simpan ke database artikel.
     *
     * @return array{category: string, synced: int, skipped: int, total_fetched: int}
     */
    public function fetchAndSync(string $category, string $query, int $limit = 5, ?int $authorId = null): array
    {
        $encodedQuery = urlencode($query);
        $url = "https://news.google.com/rss/search?q={$encodedQuery}&hl=id&gl=ID&ceid=ID:id";

        $syncedCount = 0;
        $skippedCount = 0;
        $totalFetched = 0;

        try {
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            ])->timeout(12)->get($url);

            if (! $response->successful()) {
                Log::warning("RSS fetch failed for query [{$query}] with status: ".$response->status());

                return [
                    'category' => $category,
                    'synced' => 0,
                    'skipped' => 0,
                    'total_fetched' => 0,
                ];
            }

            $body = $response->body();
            $xml = @simplexml_load_string($body);

            if (! $xml || ! isset($xml->channel->item)) {
                return [
                    'category' => $category,
                    'synced' => 0,
                    'skipped' => 0,
                    'total_fetched' => 0,
                ];
            }

            foreach ($xml->channel->item as $item) {
                if ($totalFetched >= $limit) {
                    break;
                }
                $totalFetched++;

                $rawTitle = (string) $item->title;
                $link = (string) $item->link;
                $sourceName = isset($item->source) ? (string) $item->source : 'Portal Edukasi';

                // Bersihkan judul dari akhiran " - NamaMedia" jika ada
                $cleanTitle = $rawTitle;
                if (str_contains($rawTitle, ' - ')) {
                    $parts = explode(' - ', $rawTitle);
                    $sourceCandidate = array_pop($parts);
                    if (empty($sourceName) || $sourceName === 'Portal Edukasi') {
                        $sourceName = trim($sourceCandidate);
                    }
                    $cleanTitle = trim(implode(' - ', $parts));
                }

                // Cek apakah artikel dengan link atau judul yang sama sudah ada di DB
                $exists = Article::where('source_url', $link)
                    ->orWhere('title', $cleanTitle)
                    ->exists();

                if ($exists) {
                    $skippedCount++;

                    continue;
                }

                $slugBase = Str::slug($cleanTitle);
                $slug = $slugBase;
                $counter = 1;
                while (Article::where('slug', $slug)->exists()) {
                    $slug = $slugBase.'-'.(++$counter);
                }

                $categoryLabel = match ($category) {
                    'tips_ptn' => 'Tips Lolos PTN & SNBP',
                    'kesehatan_mental' => 'Kesehatan Mental Remaja',
                    default => 'Edukasi Bimbingan',
                };

                // Susun isi konten edukasi dengan atribusi sumber yang etis & rapi
                $cleanContent = "<p>Artikel edukasi bimbingan konseling ini mengulas topik <strong>{$cleanTitle}</strong> yang sangat bermanfaat sebagai referensi siswa SMA Negeri 4 Jember dalam pendampingan <em>{$categoryLabel}</em>.</p>"
                    ."<p>Materi ini dipublikasikan oleh <strong>{$sourceName}</strong> dan disindikasikan secara otomatis ke portal literasi bimbingan konseling digital SAPA BK demi memperluas wawasan dan literasi siswa.</p>"
                    .'<p>Untuk membaca liputan serta panduan mendalam selengkapnya dari narasumber, silakan kunjungi publikasi rujukan resmi melalui tautan di bawah.</p>';

                Article::create([
                    'title' => $cleanTitle,
                    'slug' => $slug,
                    'category' => $category,
                    'content' => $cleanContent,
                    'source_name' => $sourceName,
                    'source_url' => $link,
                    'is_published' => true,
                    'author_id' => $authorId,
                ]);

                $syncedCount++;
            }
        } catch (\Throwable $e) {
            Log::error('Error syncing RSS articles: '.$e->getMessage());
        }

        return [
            'category' => $category,
            'synced' => $syncedCount,
            'skipped' => $skippedCount,
            'total_fetched' => $totalFetched,
        ];
    }
}
