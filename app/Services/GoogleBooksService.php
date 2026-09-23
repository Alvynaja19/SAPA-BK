<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GoogleBooksService
{
    protected string $endpoint;

    protected ?string $apiKey;

    public function __construct()
    {
        $this->endpoint = config('services.google_books.endpoint', 'https://www.googleapis.com/books/v1/volumes');
        $this->apiKey = config('services.google_books.key');
    }

    /**
     * Melakukan pencarian buku melalui Google Books API dengan sistem Caching dan Fallback Kurasi.
     *
     * @return array<string, mixed>
     */
    public function search(string $query, int $maxResults = 20, int $startIndex = 0, string $lang = 'id'): array
    {
        $cleanQuery = trim($query);
        if ($cleanQuery === '') {
            $cleanQuery = 'kesehatan mental remaja';
        }

        // Cache hasil query selama 24 jam untuk menghemat kuota API Google
        $cacheKey = 'google_books_'.md5(strtolower($cleanQuery).'_'.$maxResults.'_'.$startIndex.'_'.$lang);

        return Cache::remember($cacheKey, 86400, function () use ($cleanQuery, $maxResults, $startIndex, $lang) {
            try {
                $params = [
                    'q' => $cleanQuery,
                    'maxResults' => min(40, max(1, $maxResults)),
                    'startIndex' => max(0, $startIndex),
                    'orderBy' => 'relevance',
                ];

                if ($lang !== 'all' && $lang !== '') {
                    $params['langRestrict'] = $lang;
                }

                if (! empty($this->apiKey)) {
                    $params['key'] = $this->apiKey;
                }

                $response = Http::timeout(6)
                    ->withHeaders([
                        'User-Agent' => 'SAPA-BK-SMA4Jember/1.0',
                        'Accept' => 'application/json',
                    ])
                    ->get($this->endpoint, $params);

                if ($response->successful()) {
                    $data = $response->json();
                    $items = $data['items'] ?? [];

                    if (! empty($items)) {
                        $normalizedBooks = array_values(array_filter(array_map(
                            fn (array $item) => $this->normalizeGoogleBook($item),
                            $items
                        )));

                        return [
                            'success' => true,
                            'source' => 'google_books',
                            'total' => $data['totalItems'] ?? count($normalizedBooks),
                            'query' => $cleanQuery,
                            'books' => $normalizedBooks,
                        ];
                    }
                }

                // Jika respons Google tidak mengembalikan item atau kuota 429
                Log::warning('Google Books API tidak mengembalikan item atau terkena limit kuota. Menggunakan fallback kurasi.', [
                    'status' => $response->status(),
                    'query' => $cleanQuery,
                ]);
            } catch (\Throwable $e) {
                Log::notice('Gagal terhubung ke Google Books API, mengalihkan ke katalog kurasi lokal: '.$e->getMessage());
            }

            // Fallback: Ambil data dari katalog kurasi lokal SAPA BK
            $curatedResults = CuratedEbookCatalog::search($cleanQuery);

            return [
                'success' => true,
                'source' => 'curated_fallback',
                'total' => count($curatedResults),
                'query' => $cleanQuery,
                'books' => $curatedResults,
            ];
        });
    }

    /**
     * Mengambil daftar buku berdasarkan topik kategori khusus.
     *
     * @return array<string, mixed>
     */
    public function getByCategory(string $category, int $maxResults = 15): array
    {
        // Kategori buku materi pelajaran SMA langsung diarahkan ke sumber resmi Kemendikbud
        if ($category === 'materi_sma') {
            $books = CuratedEbookCatalog::smaStudyBooks();

            return [
                'success' => true,
                'source' => 'kemdikbud_sibi',
                'total' => count($books),
                'category' => $category,
                'books' => array_slice($books, 0, $maxResults),
            ];
        }

        $queryMap = [
            'kesehatan_mental' => 'kesehatan mental remaja psikologi',
            'stres_belajar' => 'manajemen stres motivasi belajar siswa',
            'psikologi_remaja' => 'psikologi remaja bimbingan konseling',
            'pengembangan_diri' => 'pengembangan diri kepercayaan diri remaja',
            'karir_kuliah' => 'bimbingan karir masa depan jurusan kuliah snbp',
        ];

        $targetQuery = $queryMap[$category] ?? 'kesehatan mental remaja';

        return $this->search($targetQuery, $maxResults);
    }

    /**
     * Mengambil detail buku berdasarkan ID (Google Books Volume ID atau ID Kurasi).
     *
     * @return array<string, mixed>|null
     */
    public function getDetail(string $id): ?array
    {
        if (str_starts_with($id, 'curated-')) {
            return CuratedEbookCatalog::find($id);
        }

        $cacheKey = 'google_book_detail_'.md5($id);

        return Cache::remember($cacheKey, 86400, function () use ($id) {
            try {
                $params = [];
                if (! empty($this->apiKey)) {
                    $params['key'] = $this->apiKey;
                }

                $response = Http::timeout(6)
                    ->withHeaders([
                        'User-Agent' => 'SAPA-BK-SMA4Jember/1.0',
                        'Accept' => 'application/json',
                    ])
                    ->get("{$this->endpoint}/{$id}", $params);

                if ($response->successful()) {
                    return $this->normalizeGoogleBook($response->json());
                }
            } catch (\Throwable $e) {
                Log::warning('Gagal mengambil detail Google Book ID: '.$id.' | Error: '.$e->getMessage());
            }

            return null;
        });
    }

    /**
     * Menstandarisasi struktur data buku dari Google Books ke format seragam SAPA BK.
     *
     * @param  array<string, mixed>  $item
     * @return array<string, mixed>|null
     */
    protected function normalizeGoogleBook(array $item): ?array
    {
        $volumeInfo = $item['volumeInfo'] ?? null;
        if (! $volumeInfo || empty($volumeInfo['title'])) {
            return null;
        }

        $id = $item['id'] ?? '';
        $authors = $volumeInfo['authors'] ?? ['Penulis Anonim'];
        $publisher = $volumeInfo['publisher'] ?? 'Penerbit Terbuka';
        $publishedDate = $volumeInfo['publishedDate'] ?? '2023';
        $publishedYear = strlen($publishedDate) >= 4 ? substr($publishedDate, 0, 4) : $publishedDate;

        $imageLinks = $volumeInfo['imageLinks'] ?? [];
        $rawThumbnail = $imageLinks['thumbnail'] ?? $imageLinks['smallThumbnail'] ?? null;

        // Pastikan URL thumbnail menggunakan protokol HTTPS aman
        $coverUrl = $rawThumbnail
            ? str_replace('http://', 'https://', $rawThumbnail)
            : 'https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=600&q=80';

        $accessInfo = $item['accessInfo'] ?? [];
        $isEmbeddable = (bool) ($accessInfo['embeddable'] ?? true);
        $previewLink = $volumeInfo['previewLink'] ?? null;

        // URL sematan pratinjau buku Google Books
        $readerUrl = "https://books.google.com/books?id={$id}&lpg=PP1&pg=PP1&output=embed";

        return [
            'id' => $id,
            'title' => $volumeInfo['title'],
            'authors' => $authors,
            'publisher' => $publisher,
            'published_year' => $publishedYear,
            'description' => strip_tags($volumeInfo['description'] ?? 'E-book referensi terpercaya mengenai psikologi, bimbingan konseling, dan pengembangan potensi siswa.'),
            'cover_url' => $coverUrl,
            'page_count' => $volumeInfo['pageCount'] ?? null,
            'language' => $volumeInfo['language'] ?? 'id',
            'categories' => $volumeInfo['categories'] ?? ['Bimbingan & Konseling'],
            'is_curated' => false,
            'reader_type' => 'google_embed',
            'reader_url' => $readerUrl,
            'preview_link' => $previewLink,
            'embeddable' => $isEmbeddable,
            'source' => 'Google Books',
            'badges' => ['Google Books', 'Pratinjau Daring'],
        ];
    }
}
