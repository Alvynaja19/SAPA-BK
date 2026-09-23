<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CuratedEbookCatalog;
use App\Services\GoogleBooksService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EbookApiController extends Controller
{
    public function __construct(
        protected GoogleBooksService $googleBooksService
    ) {}

    /**
     * Pencarian buku daring (Google Books API & Katalog Kurasi SMA).
     */
    public function search(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:150'],
            'category' => ['nullable', 'string', 'max:50'],
            'class_level' => ['nullable', 'string', 'max:20'],
            'limit' => ['nullable', 'integer', 'min:1', 'max:40'],
            'page' => ['nullable', 'integer', 'min:1'],
        ]);

        $query = trim($validated['q'] ?? '');
        $category = $validated['category'] ?? null;
        $classLevel = $validated['class_level'] ?? null;
        $limit = (int) ($validated['limit'] ?? 20);
        $page = (int) ($validated['page'] ?? 1);
        $startIndex = ($page - 1) * $limit;

        // Jika kategori khusus materi SMA atau filter jenjang kelas dipilih
        if ($category === 'materi_sma' || ! empty($classLevel)) {
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

        // Jika kategori tertentu dipilih tanpa query spesifik
        if (! empty($category) && $query === '') {
            $result = $this->googleBooksService->getByCategory($category, $limit);

            return response()->json(array_merge(['count' => count($result['books'] ?? [])], $result));
        }

        // Pencarian umum via Google Books Service
        $result = $this->googleBooksService->search($query, $limit, $startIndex);

        return response()->json(array_merge(['count' => count($result['books'] ?? [])], $result));
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
                'description' => 'Seluruh referensi buku bimbingan, kesehatan jiwa, dan materi SMA.',
                'icon' => 'book-open',
            ],
            [
                'slug' => 'kesehatan_mental',
                'name' => 'Kesehatan Mental & Regulasi Emosi',
                'description' => 'Panduan mengatasi cemas, memulihkan ketenangan, dan menjaga kesehatan jiwa.',
                'icon' => 'heart',
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
