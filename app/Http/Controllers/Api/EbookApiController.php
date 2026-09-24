<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CuratedEbookCatalog;
use App\Services\GoogleBooksService;
use App\Services\OpenLibraryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EbookApiController extends Controller
{
    public function __construct(
        protected GoogleBooksService $googleBooksService,
        protected OpenLibraryService $openLibraryService
    ) {}

    /**
     * Pencarian buku terpadu (Hybrid: Kemenkes & UNICEF, Open Library, Google Books, dan SIBI SMA).
     */
    public function search(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:150'],
            'category' => ['nullable', 'string', 'max:50'],
            'source' => ['nullable', 'string', 'in:all,kemenkes_unicef,open_library,google_books,materi_sma'],
            'class_level' => ['nullable', 'string', 'max:20'],
            'limit' => ['nullable', 'integer', 'min:1', 'max:40'],
            'page' => ['nullable', 'integer', 'min:1'],
        ]);

        $query = trim($validated['q'] ?? '');
        $category = $validated['category'] ?? null;
        $source = $validated['source'] ?? 'all';
        $classLevel = $validated['class_level'] ?? null;
        $limit = (int) ($validated['limit'] ?? 20);
        $page = (int) ($validated['page'] ?? 1);
        $startIndex = ($page - 1) * $limit;

        // 1. Filter Khusus: Koleksi Resmi Kemenkes RI & UNICEF Indonesia
        if ($source === 'kemenkes_unicef' || $category === 'kemenkes_unicef') {
            $allKemenkes = CuratedEbookCatalog::kemenkesUnicefBooks();
            if ($query !== '') {
                $q = strtolower($query);
                $allKemenkes = array_values(array_filter($allKemenkes, function ($b) use ($q) {
                    $searchable = strtolower(($b['title'] ?? '').' '.implode(' ', $b['authors'] ?? []).' '.($b['description'] ?? ''));

                    return str_contains($searchable, $q);
                }));
            }

            return response()->json([
                'success' => true,
                'source' => 'kemenkes_unicef',
                'query' => $query,
                'total' => count($allKemenkes),
                'count' => count($allKemenkes),
                'books' => array_slice($allKemenkes, $startIndex, $limit),
            ]);
        }

        // 2. Filter Khusus: Open Library / Internet Archive API
        if ($source === 'open_library' || $category === 'open_library') {
            $result = $this->openLibraryService->search($query, $limit, $page);

            return response()->json(array_merge([
                'count' => count($result['books'] ?? []),
            ], $result));
        }

        // 3. Filter Khusus: Materi SMA Kurikulum Merdeka (SIBI Kemendikbudristek)
        if ($source === 'materi_sma' || $category === 'materi_sma' || ! empty($classLevel)) {
            $books = CuratedEbookCatalog::search($query, 'materi_sma', $classLevel);

            return response()->json([
                'success' => true,
                'source' => 'kemdikbud_sibi',
                'query' => $query,
                'category' => $category ?? 'materi_sma',
                'class_level' => $classLevel,
                'total' => count($books),
                'count' => count($books),
                'books' => array_slice($books, $startIndex, $limit),
            ]);
        }

        // 4. Jika Kategori Tematik Tertentu Dipilih tanpa kata kunci spesifik
        if (! empty($category) && $category !== 'semua' && $query === '') {
            $curatedMatches = CuratedEbookCatalog::search('', $category);
            $googleResults = $this->googleBooksService->getByCategory($category, 12);
            $merged = array_merge($curatedMatches, $googleResults['books'] ?? []);

            return response()->json([
                'success' => true,
                'source' => 'hybrid_category',
                'category' => $category,
                'total' => count($merged),
                'count' => count($merged),
                'books' => array_slice($merged, 0, $limit),
            ]);
        }

        // 5. Pencarian Campuran (Hybrid Search): Prioritaskan modul Kemenkes/UNICEF & Kurasi lokal, lalu Open Library & Google Books
        $curatedMatches = CuratedEbookCatalog::search($query, $category, $classLevel);

        // Ambil dari Open Library API
        $olResults = $this->openLibraryService->search($query, 12, $page);
        $olBooks = $olResults['books'] ?? [];

        // Ambil dari Google Books API sebagai pelengkap
        $gbResults = $this->googleBooksService->search($query, 10, $startIndex);
        $gbBooks = $gbResults['books'] ?? [];

        // Gabungkan dengan urutan prioritas: Kurasi Lokal (Kemenkes/UNICEF/SIBI) -> Open Library -> Google Books
        $mergedBooks = $curatedMatches;
        $seenTitles = [];

        foreach ($mergedBooks as $b) {
            $seenTitles[strtolower(trim($b['title']))] = true;
        }

        foreach ($olBooks as $b) {
            $normTitle = strtolower(trim($b['title']));
            if (! isset($seenTitles[$normTitle])) {
                $seenTitles[$normTitle] = true;
                $mergedBooks[] = $b;
            }
        }

        foreach ($gbBooks as $b) {
            $normTitle = strtolower(trim($b['title']));
            if (! isset($seenTitles[$normTitle])) {
                $seenTitles[$normTitle] = true;
                $mergedBooks[] = $b;
            }
        }

        return response()->json([
            'success' => true,
            'source' => 'hybrid_unified',
            'query' => $query,
            'total' => count($mergedBooks),
            'count' => count($mergedBooks),
            'breakdown' => [
                'curated_count' => count($curatedMatches),
                'open_library_count' => count($olBooks),
                'google_books_count' => count($gbBooks),
            ],
            'books' => array_slice($mergedBooks, 0, $limit),
        ]);
    }

    /**
     * Mengambil daftar kategori e-book terkurasi untuk siswa.
     */
    public function categories(): JsonResponse
    {
        $categories = [
            [
                'slug' => 'semua',
                'name' => 'Semua Koleksi',
                'description' => 'Seluruh referensi bimbingan konseling, kesehatan jiwa remaja, materi SMA, dan literasi dunia.',
                'icon' => 'book-open',
            ],
            [
                'slug' => 'kemenkes_unicef',
                'name' => 'Kemenkes & UNICEF',
                'description' => 'Modul resmi kesehatan jiwa remaja, pencegahan perundungan Roots, dan pertolongan pertama emosi.',
                'icon' => 'shield-check',
            ],
            [
                'slug' => 'kesehatan_mental',
                'name' => 'Kesehatan Mental & Regulasi Emosi',
                'description' => 'Panduan mengatasi cemas, memulihkan ketenangan, dan menjaga kesehatan jiwa.',
                'icon' => 'heart',
            ],
            [
                'slug' => 'open_library',
                'name' => 'Open Library (Dunia)',
                'description' => 'Arsip buku digital dunia dari Internet Archive untuk psikologi, sains, dan literasi terbuka.',
                'icon' => 'globe-alt',
            ],
            [
                'slug' => 'materi_sma',
                'name' => 'Materi SMA Kurikulum Merdeka',
                'description' => 'Buku teks resmi Kemendikbudristek untuk Kelas X, XI, dan XII.',
                'icon' => 'academic-cap',
            ],
            [
                'slug' => 'stres_belajar',
                'name' => 'Manajemen Stres & Waktu',
                'description' => 'Tips teruji mencegah kejenuhan belajar dan membagi waktu secara sehat.',
                'icon' => 'clock',
            ],
            [
                'slug' => 'psikologi_remaja',
                'name' => 'Psikologi & Pertemanan Remaja',
                'description' => 'Memahami dinamika emosi remaja, komunikasi asertif, dan hubungan sehat.',
                'icon' => 'users',
            ],
            [
                'slug' => 'karir_kuliah',
                'name' => 'Bimbingan Karir & Sukses PTN',
                'description' => 'Persiapan memilih jurusan kuliah, eksplorasi potensi, dan seleksi SNBP/SNBT.',
                'icon' => 'compass',
            ],
        ];

        return response()->json([
            'success' => true,
            'categories' => $categories,
        ]);
    }

    /**
     * Mengambil detail dan konfigurasi pembaca buku berdasarkan ID.
     */
    public function detail(string $id): JsonResponse
    {
        // 1. Cek jika buku berasal dari katalog kurasi lokal (Kemenkes, UNICEF, SIBI)
        if (str_starts_with($id, 'curated-')) {
            $curated = CuratedEbookCatalog::find($id);
            if ($curated) {
                return response()->json([
                    'success' => true,
                    'book' => $this->googleBooksService->sanitizeBookUrls($curated),
                ]);
            }
        }

        // 2. Cek jika buku berasal dari Open Library (format: ol-OLxxxxW)
        if (str_starts_with($id, 'ol-')) {
            $olBook = $this->openLibraryService->getDetail($id);
            if ($olBook) {
                return response()->json([
                    'success' => true,
                    'book' => $olBook,
                ]);
            }
        }

        // 3. Fallback: Google Books Service
        $book = $this->googleBooksService->getDetail($id);

        if (! $book) {
            return response()->json([
                'success' => false,
                'message' => 'Buku tidak ditemukan atau tautan telah kedaluwarsa.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'book' => $book,
        ]);
    }
}
