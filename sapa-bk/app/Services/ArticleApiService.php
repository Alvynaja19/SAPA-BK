<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ArticleApiService
{
    protected int $cacheTtl = 7200;

    /**
     * Fetch curated & public guidance and counseling articles tailored for SMA students.
     *
     * @param string|null $query
     * @param string|null $category
     * @param int $page
     * @param int $perPage
     * @return array
     */
    public function fetchPublicArticles(?string $query = '', ?string $category = 'all', int $page = 1, int $perPage = 9): array
    {
        $cleanQuery = strtolower(trim((string) $query));
        $cleanCategory = strtolower(trim((string) $category));

        $cacheKey = 'bk_sma_articles_v2_' . md5($cleanQuery . '_' . $cleanCategory . '_' . $page . '_' . $perPage);

        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($cleanQuery, $cleanCategory, $page, $perPage) {
            // 1. Get Curated Educational BK Articles for SMA
            $curated = $this->getCuratedSmaArticles();

            // 2. Fetch live OpenAlex articles with strict filtering
            $liveOpenAlex = $this->fetchFromOpenAlexFiltered($cleanQuery ?: 'bimbingan konseling sma');

            // 3. Fetch live Crossref articles with strict filtering
            $liveCrossref = $this->fetchFromCrossrefFiltered($cleanQuery ?: 'bimbingan konseling sma');

            // Merge all articles
            $allArticles = array_merge($curated, $liveOpenAlex, $liveCrossref);

            // Filter by Category if specified
            if ($cleanCategory !== 'all' && !empty($cleanCategory)) {
                $allArticles = array_values(array_filter($allArticles, function ($art) use ($cleanCategory) {
                    return isset($art['category_key']) && $art['category_key'] === $cleanCategory;
                }));
            }

            // Filter by Query if specified
            if ($cleanQuery !== '') {
                $allArticles = array_values(array_filter($allArticles, function ($art) use ($cleanQuery) {
                    $searchable = strtolower($art['title'] . ' ' . $art['abstract'] . ' ' . ($art['tags'] ?? ''));
                    return str_contains($searchable, $cleanQuery);
                }));
            }

            // Pagination slice
            $total = count($allArticles);
            $offset = ($page - 1) * $perPage;
            $pagedData = array_slice($allArticles, $offset, $perPage);

            return [
                'data' => $pagedData,
                'total' => $total,
                'page' => $page,
                'perPage' => $perPage,
                'lastPage' => max(1, (int) ceil($total / $perPage)),
            ];
        });
    }

    /**
     * Curated Educational BK Articles Collection for High School Students
     */
    protected function getCuratedSmaArticles(): array
    {
        return [
            [
                'id' => md5('sma_mental_1'),
                'title' => 'Mengatasi Stress dan Academic Burnout Saat Menghadapi Ujian SMA',
                'author' => 'Tim Konselor BK SMAN 4 Jember',
                'journal' => 'Edukasi Kesehatan Mental Siswa',
                'year' => 2026,
                'category' => 'Kesehatan Mental',
                'category_key' => 'mental',
                'abstract' => 'Panduan praktis bagi siswa SMA dalam mengenali gejala academic burnout, mengelola tingkat kecemasan ujian, dan menerapkan teknik pertolongan pertama relaksasi napas (box breathing) agar tetap fokus.',
                'url' => 'https://id.wikipedia.org/wiki/Kesehatan_mental',
                'source' => 'Edukasi BK',
                'tags' => 'stress ujian burnout kesehatan mental sekolah',
            ],
            [
                'id' => md5('sma_karir_1'),
                'title' => 'Panduan Memilih Jurusan Kuliah Sesuai Minat, Bakat, dan Potensi Karir',
                'author' => 'Pusat Bimbingan Karir SMA',
                'journal' => 'Orientasi Karir & Perguruan Tinggi',
                'year' => 2026,
                'category' => 'Karir & Perencanaan Kuliah',
                'category_key' => 'karir',
                'abstract' => 'Strategi menentukan jurusan di perguruan tinggi negeri (PTN) melalui jalur SNBP dan SNBT. Dilengkapi tips pemetaan potensi diri, linieritas mata pelajaran, dan analisis peluang lulus.',
                'url' => 'https://id.wikipedia.org/wiki/Perencanaan_karier',
                'source' => 'Edukasi BK',
                'tags' => 'karir kuliah jurusan snbp snbt ptn universitas',
            ],
            [
                'id' => md5('sma_belajar_1'),
                'title' => 'Teknik Belajar Efektif Pomodoro & Spaced Repetition untuk Pelajar SMA',
                'author' => 'Divisi Efektivitas Belajar BK',
                'journal' => 'Jurnal Metode Pembelajaran Modern',
                'year' => 2025,
                'category' => 'Strategi Belajar',
                'category_key' => 'belajar',
                'abstract' => 'Cara meningkatkan konsentrasi dan daya ingat dalam belajar menggunakan interval waktu 25 menit (Pomodoro) serta pengulangan berkala agar materi pelajaran tidak mudah lupa.',
                'url' => 'https://id.wikipedia.org/wiki/Teknik_Pomodoro',
                'source' => 'Edukasi BK',
                'tags' => 'belajar pomodoro konsentrasi waktu ujian',
            ],
            [
                'id' => md5('sma_pengembangan_1'),
                'title' => 'Membangun Rasa Percaya Diri dan Keterampilan Public Speaking Siswa',
                'author' => 'Tim Bimbingan Pribadi-Sosial BK',
                'journal' => 'Pengembangan Karakter Pelajar',
                'year' => 2025,
                'category' => 'Pengembangan Diri',
                'category_key' => 'pengembangan',
                'abstract' => 'Langkah-langkah praktis mengikis rasa minder dan gugup saat tampil berbicara di depan kelas atau organisasi sekolah, serta kiat membangun bahasa tubuh yang percaya diri.',
                'url' => 'https://id.wikipedia.org/wiki/Kepercayaan_diri',
                'source' => 'Edukasi BK',
                'tags' => 'percaya diri public speaking sosial pergaulan',
            ],
            [
                'id' => md5('sma_mental_2'),
                'title' => 'Pentingnya Self-Care dan Manajemen Emosi Remaja Usia Sekolah Menengah',
                'author' => 'Asosiasi Bimbingan Konseling Indonesia (ABKIN)',
                'journal' => 'Jurnal Psikologi & Konseling Remaja',
                'year' => 2025,
                'category' => 'Kesehatan Mental',
                'category_key' => 'mental',
                'abstract' => 'Mengapa regulasi emosi sangat krusial bagi remaja usia 15-18 tahun. Artikel ini membahas kiat mengendalikan mood swing, menjaga tidur cukup, dan menjalin komunikasi terbuka dengan orang tua/guru BK.',
                'url' => 'https://id.wikipedia.org/wiki/Regulasi_emosi',
                'source' => 'ABKIN Edukasi',
                'tags' => 'self care emosi remaja mood mental health',
            ],
            [
                'id' => md5('sma_karir_2'),
                'title' => 'Mengenal Tes Minat Bakat (Holland Code / RIASEC) untuk Masa Depan Siswa',
                'author' => 'Lembaga Asesmen Psikologi Pendidikan',
                'journal' => 'Bimbingan Penelusuran Minat Bakat',
                'year' => 2025,
                'category' => 'Karir & Perencanaan Kuliah',
                'category_key' => 'karir',
                'abstract' => 'Penjelasan 6 tipe kepribadian karir (Realistic, Investigative, Artistic, Social, Enterprising, Conventional) untuk membantu siswa SMA memilih pekerjaan yang paling cocok.',
                'url' => 'https://id.wikipedia.org/wiki/Teori_pilihan_karier_Holland',
                'source' => 'Psikologi Edukasi',
                'tags' => 'tes minat bakat riasec karir pekerjaan cita-cita',
            ],
            [
                'id' => md5('sma_belajar_2'),
                'title' => 'Manajemen Waktu Antara Akademik, Ekstrakurikuler, dan Istirahat',
                'author' => 'Konselor Sekolah Menengah',
                'journal' => 'Media Manajemen Diri Siswa',
                'year' => 2026,
                'category' => 'Strategi Belajar',
                'category_key' => 'belajar',
                'abstract' => 'Kiat membagi waktu secara seimbang agar kegiatan organisasi/osom/ekstrakurikuler tetap berjalan lancar tanpa mengorbankan nilai akademik dan kesehatan fisik.',
                'url' => 'https://id.wikipedia.org/wiki/Manajemen_waktu',
                'source' => 'Edukasi BK',
                'tags' => 'manajemen waktu osis ekskul jadwal prioritas',
            ],
            [
                'id' => md5('sma_pengembangan_2'),
                'title' => 'Mencegah dan Menghadapi Cyberbullying di Lingkungan Pergaulan Remaja',
                'author' => 'Satgas Anti-Bullying BK',
                'journal' => 'Perlindungan & Etika Digital Pelajar',
                'year' => 2025,
                'category' => 'Pengembangan Diri',
                'category_key' => 'pengembangan',
                'abstract' => 'Pemahaman mengenai bentuk-bentuk perundungan siber (cyberbullying), dampaknya pada mental, serta langkah tegas melapor dan membentengi diri dari perlakuan tidak menyenangkan.',
                'url' => 'https://id.wikipedia.org/wiki/Perundungan_siber',
                'source' => 'Edukasi BK',
                'tags' => 'cyberbullying anti bullying media sosial perlindungan',
            ],
        ];
    }

    /**
     * Fetch from OpenAlex API with strict filtering
     */
    protected function fetchFromOpenAlexFiltered(string $query): array
    {
        try {
            $response = Http::timeout(5)
                ->withHeaders(['User-Agent' => 'SAPA-BK-App/1.0 (mailto:bk@sman4jember.sch.id)'])
                ->get('https://api.openalex.org/works', [
                    'search' => $query,
                    'per_page' => 12,
                ]);

            if (!$response->successful()) return [];

            $json = $response->json();
            $results = $json['results'] ?? [];

            $valid = [];
            foreach ($results as $item) {
                $title = trim($item['title'] ?? $item['display_name'] ?? '');
                $journal = trim($item['primary_location']['source']['display_name'] ?? 'Jurnal Publik BK');
                $url = $item['primary_location']['landing_page_url'] ?? $item['doi'] ?? null;

                if (!$this->isValidArticleTitle($title, $journal) || !$url) {
                    continue;
                }

                $authors = [];
                if (!empty($item['authorships'])) {
                    foreach ($item['authorships'] as $authorship) {
                        $name = $authorship['author']['display_name'] ?? '';
                        if ($name) $authors[] = $name;
                    }
                }
                $authorStr = !empty($authors) ? implode(', ', array_slice($authors, 0, 2)) : 'Penulis Riset';

                $year = $item['publication_year'] ?? 2024;

                // Determine category
                $catKey = 'mental';
                $catName = 'Kesehatan Mental';
                $lowerTitle = strtolower($title);
                if (str_contains($lowerTitle, 'karir') || str_contains($lowerTitle, 'career') || str_contains($lowerTitle, 'kuliah')) {
                    $catKey = 'karir';
                    $catName = 'Karir & Perencanaan Kuliah';
                } elseif (str_contains($lowerTitle, 'belajar') || str_contains($lowerTitle, 'studi') || str_contains($lowerTitle, 'learning')) {
                    $catKey = 'belajar';
                    $catName = 'Strategi Belajar';
                } elseif (str_contains($lowerTitle, 'sosial') || str_contains($lowerTitle, 'diri') || str_contains($lowerTitle, 'karakter')) {
                    $catKey = 'pengembangan';
                    $catName = 'Pengembangan Diri';
                }

                $valid[] = [
                    'id' => md5($item['id'] ?? $title),
                    'title' => $title,
                    'author' => $authorStr,
                    'journal' => $journal,
                    'year' => $year,
                    'category' => $catName,
                    'category_key' => $catKey,
                    'abstract' => 'Publikasi ilmiah mengenai ' . Str::lower($title) . ' untuk referensi bimbingan konseling.',
                    'url' => $url,
                    'source' => 'OpenAlex API',
                    'tags' => 'jurnal riset bimbingan konseling',
                ];
            }

            return $valid;

        } catch (\Throwable $e) {
            \Log::warning('OpenAlex Filtered Fetch Warning: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Fetch from Crossref API with strict filtering
     */
    protected function fetchFromCrossrefFiltered(string $query): array
    {
        try {
            $response = Http::timeout(5)
                ->withHeaders(['User-Agent' => 'SAPA-BK-App/1.0 (mailto:bk@sman4jember.sch.id)'])
                ->get('https://api.crossref.org/works', [
                    'query' => $query,
                    'rows' => 12,
                    'sort' => 'relevance',
                ]);

            if (!$response->successful()) return [];

            $json = $response->json();
            $items = $json['message']['items'] ?? [];

            $valid = [];
            foreach ($items as $item) {
                $rawTitle = $item['title'] ?? null;
                $title = is_array($rawTitle) ? ($rawTitle[0] ?? '') : (is_string($rawTitle) ? $rawTitle : '');
                $title = trim(strip_tags($title));

                $journalRaw = $item['container-title'] ?? ($item['publisher'] ?? 'Jurnal BK');
                $journal = is_array($journalRaw) ? ($journalRaw[0] ?? 'Jurnal BK') : $journalRaw;
                $journal = trim(strip_tags($journal));

                $doi = $item['DOI'] ?? null;
                $url = !empty($item['resource']['primary']['URL']) 
                    ? $item['resource']['primary']['URL'] 
                    : ($doi ? 'https://doi.org/' . $doi : ($item['URL'] ?? null));

                // Strict validation check
                if (!$this->isValidArticleTitle($title, $journal) || !$url) {
                    continue;
                }

                // Format authors
                $authors = [];
                if (!empty($item['author'])) {
                    foreach ($item['author'] as $author) {
                        $given = $author['given'] ?? '';
                        $family = $author['family'] ?? '';
                        $name = trim("$given $family");
                        if ($name) $authors[] = $name;
                    }
                }
                $authorStr = !empty($authors) ? implode(', ', array_slice($authors, 0, 2)) : $journal;

                // Year
                $year = $item['published']['date-parts'][0][0] ?? ($item['created']['date-parts'][0][0] ?? 2024);

                // Clean Abstract
                $abstract = '';
                if (!empty($item['abstract'])) {
                    $abstract = trim(strip_tags($item['abstract']));
                    $abstract = preg_replace('/\s+/', ' ', $abstract);
                }
                if (empty($abstract) || strlen($abstract) < 20) {
                    $abstract = 'Artikel riset tentang ' . Str::lower($title) . ' terbitan ' . $journal . '.';
                }

                // Determine category
                $catKey = 'mental';
                $catName = 'Kesehatan Mental';
                $lowerTitle = strtolower($title);
                if (str_contains($lowerTitle, 'karir') || str_contains($lowerTitle, 'career') || str_contains($lowerTitle, 'kerja') || str_contains($lowerTitle, 'kuliah')) {
                    $catKey = 'karir';
                    $catName = 'Karir & Perencanaan Kuliah';
                } elseif (str_contains($lowerTitle, 'belajar') || str_contains($lowerTitle, 'studi') || str_contains($lowerTitle, 'prestasi') || str_contains($lowerTitle, 'sekolah')) {
                    $catKey = 'belajar';
                    $catName = 'Strategi Belajar';
                } elseif (str_contains($lowerTitle, 'pribadi') || str_contains($lowerTitle, 'sosial') || str_contains($lowerTitle, 'karakter') || str_contains($lowerTitle, 'sikap')) {
                    $catKey = 'pengembangan';
                    $catName = 'Pengembangan Diri';
                }

                $valid[] = [
                    'id' => md5($doi ?: $title),
                    'title' => $title,
                    'author' => $authorStr,
                    'journal' => $journal,
                    'year' => $year,
                    'category' => $catName,
                    'category_key' => $catKey,
                    'abstract' => Str::limit($abstract, 200),
                    'url' => $url,
                    'source' => 'Crossref API',
                    'tags' => 'jurnal penelitian bk',
                ];
            }

            return $valid;

        } catch (\Throwable $e) {
            \Log::warning('Crossref Filtered Fetch Warning: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Strict validation: checks if article title is clean, meaningful, and not equal to "Tanpa Judul"
     */
    protected function isValidArticleTitle(string $title, string $journal): bool
    {
        if (empty($title) || strlen($title) < 8) {
            return false;
        }

        $lowerTitle = strtolower($title);
        $lowerJournal = strtolower($journal);

        // Reject default invalid placeholders
        $invalidPatterns = [
            'tanpa judul', 'untitled', 'table of contents', 'daftar isi',
            'cover depan', 'back cover', 'front cover', 'editorial board',
            'volume ', 'vol. ', 'no. ', 'issue ', 'halaman depan'
        ];

        foreach ($invalidPatterns as $pattern) {
            if (str_contains($lowerTitle, $pattern)) {
                return false;
            }
        }

        // Reject if title is identical to journal name (which means it's a journal issue DOI, not an article)
        if ($lowerTitle === $lowerJournal || str_contains($lowerTitle, 'jurnal bimbingan dan konseling') && strlen($title) < 35) {
            return false;
        }

        return true;
    }
}
