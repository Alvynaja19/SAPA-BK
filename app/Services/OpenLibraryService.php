<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenLibraryService
{
    protected string $searchEndpoint;

    protected string $worksEndpoint;

    public function __construct()
    {
        $this->searchEndpoint = config('services.open_library.search_endpoint', 'https://openlibrary.org/search.json');
        $this->worksEndpoint = config('services.open_library.works_endpoint', 'https://openlibrary.org/works');
    }

    /**
     * Melakukan pencarian buku digital dari Open Library (Internet Archive) dengan sistem caching 24 jam.
     *
     * @return array<string, mixed>
     */
    public function search(string $query, int $limit = 20, int $page = 1, ?string $language = null): array
    {
        $cleanQuery = trim($query);
        if ($cleanQuery === '') {
            $cleanQuery = 'psychology adolescent mental health';
        }

        $limit = min(30, max(1, $limit));
        $page = max(1, $page);

        $cacheKey = 'open_library_v1_'.md5(strtolower($cleanQuery).'_'.$limit.'_'.$page.'_'.($language ?? 'all'));

        return Cache::remember($cacheKey, 86400, function () use ($cleanQuery, $limit, $page, $language) {
            try {
                $params = [
                    'q' => $cleanQuery,
                    'limit' => $limit,
                    'page' => $page,
                    'fields' => 'key,title,author_name,first_publish_year,cover_i,publisher,number_of_pages_median,language,ia,subject',
                ];

                if (! empty($language) && $language !== 'all') {
                    $params['language'] = $language;
                }

                $response = Http::timeout(8)
                    ->withHeaders([
                        'User-Agent' => 'SAPA-BK-SMA4Jember/1.0 (Bimbingan Konseling Digital)',
                        'Accept' => 'application/json',
                    ])
                    ->get($this->searchEndpoint, $params);

                if ($response->successful()) {
                    $data = $response->json();
                    $docs = $data['docs'] ?? [];

                    $books = [];
                    foreach ($docs as $doc) {
                        $normalized = $this->normalizeBook($doc);
                        if ($normalized !== null) {
                            $books[] = $normalized;
                        }
                    }

                    return [
                        'success' => true,
                        'source' => 'open_library',
                        'total' => $data['num_found'] ?? count($books),
                        'page' => $page,
                        'limit' => $limit,
                        'query' => $cleanQuery,
                        'books' => $books,
                    ];
                }

                Log::warning('Open Library API mengembalikan status gagal: '.$response->status());
            } catch (\Throwable $e) {
                Log::notice('Gagal terhubung ke Open Library API: '.$e->getMessage());
            }

            return [
                'success' => false,
                'source' => 'open_library',
                'total' => 0,
                'query' => $cleanQuery,
                'books' => [],
            ];
        });
    }

    /**
     * Mengambil rekomendasi buku berdasarkan kategori minat/konseling.
     *
     * @return array<string, mixed>
     */
    public function getByCategory(string $category, int $limit = 15): array
    {
        $categoryMap = [
            'kesehatan_mental' => 'mental health adolescent psychology',
            'stres_belajar' => 'stress management study skills student',
            'psikologi_remaja' => 'adolescent development youth psychology',
            'pengembangan_diri' => 'self improvement emotional intelligence',
            'karir_kuliah' => 'career guidance college planning',
        ];

        $targetQuery = $categoryMap[$category] ?? 'adolescent psychology';

        return $this->search($targetQuery, $limit);
    }

    /**
     * Mengambil detail dan link pembaca buku Open Library berdasarkan ID (format: ol-OLxxxxW).
     *
     * @return array<string, mixed>|null
     */
    public function getDetail(string $id): ?array
    {
        $cleanKey = str_replace('ol-', '', $id);
        if (! str_starts_with($cleanKey, 'OL')) {
            return null;
        }

        $cacheKey = 'open_library_detail_v1_'.md5($cleanKey);

        return Cache::remember($cacheKey, 86400, function () use ($cleanKey, $id) {
            try {
                $response = Http::timeout(8)
                    ->withHeaders([
                        'User-Agent' => 'SAPA-BK-SMA4Jember/1.0',
                        'Accept' => 'application/json',
                    ])
                    ->get("{$this->worksEndpoint}/{$cleanKey}.json");

                if ($response->successful()) {
                    $work = $response->json();
                    $title = $work['title'] ?? 'Buku Referensi Terbuka';
                    $description = 'Referensi bacaan dari repositori terbuka Internet Archive & Open Library.';
                    if (isset($work['description'])) {
                        $description = is_string($work['description'])
                            ? $work['description']
                            : ($work['description']['value'] ?? $description);
                    }

                    $covers = $work['covers'] ?? [];
                    $coverId = ! empty($covers) ? $covers[0] : null;
                    $coverUrl = $coverId
                        ? "https://covers.openlibrary.org/b/id/{$coverId}-M.jpg"
                        : 'https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=600&q=80';

                    $openLibraryUrl = "https://openlibrary.org/works/{$cleanKey}";

                    return [
                        'id' => $id,
                        'title' => $title,
                        'authors' => ['Penulis Terdaftar di Open Library'],
                        'publisher' => 'Internet Archive / Open Library',
                        'published_year' => $work['created']['value'] ?? date('Y'),
                        'description' => strip_tags($description),
                        'cover_url' => $coverUrl,
                        'page_count' => null,
                        'language' => 'id/en',
                        'category' => 'literasi_global',
                        'subject' => 'Literasi & Referensi Global',
                        'is_curated' => false,
                        'reader_type' => 'open_library_external',
                        'reader_url' => $openLibraryUrl,
                        'preview_link' => $openLibraryUrl,
                        'source' => 'Open Library',
                        'badges' => ['Open Library', 'Internet Archive'],
                    ];
                }
            } catch (\Throwable $e) {
                Log::warning("Gagal mengambil detail Open Library untuk key {$cleanKey}: ".$e->getMessage());
            }

            return null;
        });
    }

    /**
     * Menstandarisasi format dokumen Open Library agar sesuai dengan format seragam SAPA BK.
     *
     * @param  array<string, mixed>  $doc
     * @return array<string, mixed>|null
     */
    protected function normalizeBook(array $doc): ?array
    {
        $rawKey = $doc['key'] ?? null;
        if (! $rawKey || empty($doc['title'])) {
            return null;
        }

        // Contoh key: "/works/OL2661659W" -> "OL2661659W"
        $workId = str_replace('/works/', '', $rawKey);
        $id = 'ol-'.$workId;

        $authors = ! empty($doc['author_name'])
            ? array_slice($doc['author_name'], 0, 3)
            : ['Penulis Terbuka'];

        $publishYear = isset($doc['first_publish_year']) ? (string) $doc['first_publish_year'] : '2022';
        $publishers = ! empty($doc['publisher']) ? $doc['publisher'][0] : 'Open Library / Internet Archive';

        $coverId = $doc['cover_i'] ?? null;
        $coverUrl = $coverId
            ? "https://covers.openlibrary.org/b/id/{$coverId}-M.jpg"
            : 'https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=600&q=80';

        $iaIdentifiers = $doc['ia'] ?? [];
        $hasIa = ! empty($iaIdentifiers);
        $firstIa = $hasIa ? $iaIdentifiers[0] : null;

        $openLibraryUrl = "https://openlibrary.org{$rawKey}";

        // Jika buku memiliki file arsip di Internet Archive, bisa disematkan langsung via BookReader
        $readerType = $hasIa ? 'archive_embed' : 'open_library_external';
        $readerUrl = $hasIa
            ? "https://archive.org/embed/{$firstIa}"
            : $openLibraryUrl;

        $subjects = ! empty($doc['subject']) ? array_slice($doc['subject'], 0, 2) : ['Psikologi & Referensi'];
        $subjectText = implode(', ', $subjects);

        return [
            'id' => $id,
            'title' => $doc['title'],
            'authors' => $authors,
            'publisher' => $publishers,
            'published_year' => $publishYear,
            'description' => "Koleksi buku digital terbuka dari repositori Internet Archive dan Open Library dengan fokus materi {$subjectText}.",
            'cover_url' => $coverUrl,
            'page_count' => $doc['number_of_pages_median'] ?? null,
            'language' => ! empty($doc['language'][0]) ? $doc['language'][0] : 'en',
            'category' => 'literasi_global',
            'subject' => $subjectText,
            'class_level' => null,
            'is_curated' => false,
            'reader_type' => $readerType,
            'reader_url' => $readerUrl,
            'preview_link' => $openLibraryUrl,
            'embeddable' => $hasIa,
            'source' => 'Open Library',
            'badges' => ['Open Library', $hasIa ? 'Bisa Dibaca Daring' : 'Koleksi Digital'],
        ];
    }
}
