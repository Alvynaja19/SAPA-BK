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
     * Tarik feed dari Google News RSS dan simpan ke database artikel dengan thumbnail gambar.
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

                // Ekstrak gambar dari RSS feed atau sediakan gambar edukatif tematik resolusi tinggi
                $thumbnail = $this->extractOrGenerateThumbnail($item, $category, $totalFetched);

                // Susun isi konten edukasi dengan atribusi sumber yang etis & rapi
                $cleanContent = "<p>Artikel edukasi bimbingan konseling ini mengulas topik <strong>{$cleanTitle}</strong> yang sangat bermanfaat sebagai referensi siswa SMA Negeri 4 Jember dalam pendampingan <em>{$categoryLabel}</em>.</p>"
                    ."<p>Materi ini dipublikasikan oleh <strong>{$sourceName}</strong> dan disindikasikan secara otomatis ke portal literasi bimbingan konseling digital SAPA BK demi memperluas wawasan dan literasi siswa.</p>"
                    .'<p>Untuk membaca liputan serta panduan mendalam selengkapnya dari narasumber, silakan kunjungi publikasi rujukan resmi melalui tautan di bawah.</p>';

                Article::create([
                    'title' => $cleanTitle,
                    'slug' => $slug,
                    'category' => $category,
                    'content' => $cleanContent,
                    'thumbnail' => $thumbnail,
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

    /**
     * Ekstrak thumbnail dari item RSS atau gunakan gambar edukatif tematik beresolusi tinggi.
     */
    public function extractOrGenerateThumbnail(\SimpleXMLElement $item, string $category, int $index = 0): string
    {
        // 1. Cek tag <enclosure url="..." type="image/...">
        if (isset($item->enclosure) && isset($item->enclosure['url'])) {
            $enclosureUrl = (string) $item->enclosure['url'];
            if (! empty($enclosureUrl)) {
                return $enclosureUrl;
            }
        }

        // 2. Cek media:content atau media:thumbnail dari namespaces
        $namespaces = $item->getNamespaces(true);
        foreach (['media', 'content'] as $prefix) {
            if (isset($namespaces[$prefix])) {
                $media = $item->children($namespaces[$prefix]);
                if (isset($media->content) && isset($media->content->attributes()['url'])) {
                    $mediaUrl = (string) $media->content->attributes()['url'];
                    if (! empty($mediaUrl)) {
                        return $mediaUrl;
                    }
                }
                if (isset($media->thumbnail) && isset($media->thumbnail->attributes()['url'])) {
                    $thumbUrl = (string) $media->thumbnail->attributes()['url'];
                    if (! empty($thumbUrl)) {
                        return $thumbUrl;
                    }
                }
            }
        }

        // 3. Cek tag <img> di dalam description
        if (isset($item->description)) {
            $desc = (string) $item->description;
            if (preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', $desc, $matches)) {
                if (! empty($matches[1])) {
                    return $matches[1];
                }
            }
        }

        // 4. Jika RSS feed tidak menyertakan gambar (seperti feed Google News),
        // sediakan gambar edukasi tematik berkualitas tinggi yang sangat relevan
        $ptnImages = [
            'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=800&q=80', // Mahasiswa & studi lanjut
            'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?auto=format&fit=crop&w=800&q=80', // Belajar & persiapan ujian
            'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&w=800&q=80', // Gedung kampus PTN
            'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=800&q=80', // Diskusi kelompok siswa
            'https://images.unsplash.com/photo-1498243691581-b145c3f54a5a?auto=format&fit=crop&w=800&q=80', // Perpustakaan kampus
            'https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?auto=format&fit=crop&w=800&q=80', // Wisuda & masa depan
        ];

        $mentalHealthImages = [
            'https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=800&q=80', // Relaksasi & fokus pikiran
            'https://images.unsplash.com/photo-1516302752625-fcc3c50ae61f?auto=format&fit=crop&w=800&q=80', // Konseling & curhat
            'https://images.unsplash.com/photo-1499209974431-9dddcece7f88?auto=format&fit=crop&w=800&q=80', // Ketenangan batin & emosi
            'https://images.unsplash.com/photo-1507679799987-c73779587ccf?auto=format&fit=crop&w=800&q=80', // Dukungan teman & konselor
            'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=800&q=80', // Konsultasi ramah
            'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&w=800&q=80', // Circle positif remaja
        ];

        $defaultImages = [
            'https://images.unsplash.com/photo-1457369804613-52c61a468e7d?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?auto=format&fit=crop&w=800&q=80',
        ];

        if ($category === 'tips_ptn') {
            return $ptnImages[$index % count($ptnImages)];
        }

        if ($category === 'kesehatan_mental') {
            return $mentalHealthImages[$index % count($mentalHealthImages)];
        }

        return $defaultImages[$index % count($defaultImages)];
    }
}
