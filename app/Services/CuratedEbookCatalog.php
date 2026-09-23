<?php

namespace App\Services;

class CuratedEbookCatalog
{
    /**
     * Mengambil seluruh daftar buku kurasi lokal.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function all(): array
    {
        return array_merge(
            self::mentalHealthBooks(),
            self::smaStudyBooks()
        );
    }

    /**
     * Mencari buku kurasi berdasarkan kueri kata kunci atau kategori.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function search(string $query = '', ?string $category = null, ?string $classLevel = null): array
    {
        $books = self::all();

        $query = strtolower(trim($query));

        return array_values(array_filter($books, function (array $book) use ($query, $category, $classLevel): bool {
            // Filter kategori jika diberikan
            if ($category && $category !== 'semua' && ($book['category'] ?? '') !== $category) {
                return false;
            }

            // Filter jenjang kelas SMA jika diberikan
            if ($classLevel && $classLevel !== 'semua' && ($book['class_level'] ?? '') !== $classLevel) {
                return false;
            }

            // Filter kata kunci pencarian
            if ($query !== '') {
                $searchable = strtolower(
                    ($book['title'] ?? '').' '.
                    implode(' ', $book['authors'] ?? []).' '.
                    ($book['description'] ?? '').' '.
                    ($book['publisher'] ?? '').' '.
                    ($book['subject'] ?? '')
                );

                return str_contains($searchable, $query);
            }

            return true;
        }));
    }

    /**
     * Mengambil detail satu buku berdasarkan ID kurasi.
     *
     * @return array<string, mixed>|null
     */
    public static function find(string $id): ?array
    {
        foreach (self::all() as $book) {
            if ($book['id'] === $id) {
                return $book;
            }
        }

        return null;
    }

    /**
     * Koleksi E-Book Kesehatan Mental, Regulasi Emosi, dan Motivasi Belajar Remaja.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function mentalHealthBooks(): array
    {
        return [
            [
                'id' => 'curated-km-01',
                'title' => 'Panduan Pengelolaan Stres dan Regulasi Emosi Siswa SMA',
                'authors' => ['Tim Bimbingan Konseling SMAN 4 Jember', 'Dr. Ratna Indrawati, M.Psi'],
                'publisher' => 'Pusat Layanan Konseling & Edukasi SAPA BK',
                'category' => 'kesehatan_mental',
                'subject' => 'Psikologi Remaja & Regulasi Emosi',
                'class_level' => null,
                'description' => 'Modul praktis bimbingan konseling yang disusun khusus untuk peserta didik SMA. Mengulas teknik Cognitive Restructuring sederhana, latihan pernapasan diafragma (Box Breathing), serta strategi regulasi emosi saat menghadapi kecemasan akademik dan tugas bertumpuk.',
                'cover_url' => 'https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=600&q=80',
                'page_count' => 84,
                'published_year' => '2025',
                'is_curated' => true,
                'reader_type' => 'external_portal',
                'reader_url' => 'https://buku.kemendikdasmen.go.id/katalog',
                'source' => 'SAPA BK SMAN 4 Jember',
                'language' => 'Indonesia',
                'badges' => ['Rekomendasi Guru BK', 'Kesehatan Mental'],
            ],
            [
                'id' => 'curated-km-02',
                'title' => 'Kesehatan Jiwa Remaja: Mengenali Cemas, Depresi, dan Membangun Hubungan Positif',
                'authors' => ['Kementerian Kesehatan RI', 'UNICEF Indonesia'],
                'publisher' => 'Direktorat Kesehatan Jiwa Kemenkes RI',
                'category' => 'kesehatan_mental',
                'subject' => 'Kesehatan Jiwa Remaja & Peer Support',
                'class_level' => null,
                'description' => 'Buku panduan resmi literasi kesehatan mental remaja Indonesia. Membahas tanda-tanda kelelahan psikologis (burnout), cara saling mendukung antar teman sebaya (peer counseling), mengatasi stigma kesehatan jiwa, dan langkah mengakses bantuan konseling di sekolah.',
                'cover_url' => 'https://images.unsplash.com/photo-1516302752625-fcc3c50ae61f?auto=format&fit=crop&w=600&q=80',
                'page_count' => 112,
                'published_year' => '2024',
                'is_curated' => true,
                'reader_type' => 'external_portal',
                'reader_url' => 'https://ayosehat.kemkes.go.id/',
                'source' => 'Kemenkes RI & UNICEF',
                'language' => 'Indonesia',
                'badges' => ['Resmi Kemenkes', 'Literasi Jiwa'],
            ],
            [
                'id' => 'curated-km-03',
                'title' => 'Membangun Resiliensi Diri: Mengubah Kegagalan Menjadi Kekuatan Belajar',
                'authors' => ['Asosiasi Bimbingan & Konseling Indonesia (ABKIN)', 'Drs. H. Mulyadi, M.Pd'],
                'publisher' => 'Penerbit Pustaka Edukasi Konseling',
                'category' => 'kesehatan_mental',
                'subject' => 'Resiliensi & Growth Mindset',
                'class_level' => null,
                'description' => 'Membimbing siswa membangun pola pikir bertumbuh (Growth Mindset) dalam menyikapi hasil evaluasi belajar yang belum memuaskan. Dilengkapi lembar refleksi diri harian, teknik gratitude journaling, dan kiat bangkit dari rasa minder di lingkungan pertemanan.',
                'cover_url' => 'https://images.unsplash.com/photo-1499209974431-9dddcece7f88?auto=format&fit=crop&w=600&q=80',
                'page_count' => 96,
                'published_year' => '2024',
                'is_curated' => true,
                'reader_type' => 'external_portal',
                'reader_url' => 'https://buku.kemendikdasmen.go.id/katalog',
                'source' => 'ABKIN Wilayah Jatim',
                'language' => 'Indonesia',
                'badges' => ['Pengembangan Diri'],
            ],
            [
                'id' => 'curated-km-04',
                'title' => 'Strategi Manajemen Waktu dan Anti-Burnout Menjelang SNBP/SNBT',
                'authors' => ['Tim Litbang Bimbingan Karir SMAN 4 Jember'],
                'publisher' => 'SAPA BK Publishing',
                'category' => 'kesehatan_mental',
                'subject' => 'Persiapan PTN & Manajemen Belajar',
                'class_level' => 'Kelas XII',
                'description' => 'Strategi praktis mengatur ritme belajar terpadu menghadapi ujian akhir sekolah dan seleksi masuk perguruan tinggi negeri. Berisi jadwal belajar berbasis ritme sirkadian, teknik Pomodoro adaptif, serta latihan relaksasi mental sebelum menghadapi ujian penting.',
                'cover_url' => 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?auto=format&fit=crop&w=600&q=80',
                'page_count' => 76,
                'published_year' => '2025',
                'is_curated' => true,
                'reader_type' => 'external_portal',
                'reader_url' => 'https://buku.kemendikdasmen.go.id/katalog',
                'source' => 'Pusat Karir SMAN 4 Jember',
                'language' => 'Indonesia',
                'badges' => ['Kelas 12', 'Strategi Belajar'],
            ],
        ];
    }

    /**
     * Koleksi Buku Pelajaran SMA Resmi Kurikulum Merdeka (Kemendikbudristek).
     *
     * @return array<int, array<string, mixed>>
     */
    public static function smaStudyBooks(): array
    {
        return [
            // KELAS X
            [
                'id' => 'curated-sma-mat-10',
                'title' => 'Matematika untuk SMA/SMK Kelas X (Kurikulum Merdeka)',
                'authors' => ['Dickson Kho', 'Nila Kesumawati', 'Eko Budi Santoso'],
                'publisher' => 'Pusat Perbukuan Kemendikbudristek RI',
                'category' => 'materi_sma',
                'subject' => 'Matematika Umum',
                'class_level' => 'Kelas X',
                'description' => 'Buku teks utama siswa mata pelajaran Matematika Kelas X Kurikulum Merdeka. Membahas Eksponen dan Logaritma, Barisan dan Deret, Vektor dan Operasinya, Trigonometri, Sistem Persamaan Linear, serta Statistika dan Peluang terapan.',
                'cover_url' => 'https://images.unsplash.com/photo-1509228468518-180dd4864904?auto=format&fit=crop&w=600&q=80',
                'page_count' => 256,
                'published_year' => '2023',
                'is_curated' => true,
                'reader_type' => 'kemdikbud_sibi',
                'reader_url' => 'https://buku.kemendikdasmen.go.id/katalog/matematika-untuk-smasmk-kelas-x',
                'source' => 'Kemendikbudristek SIBI',
                'language' => 'Indonesia',
                'badges' => ['Buku Resmi', 'Kelas X', 'Kurikulum Merdeka'],
            ],
            [
                'id' => 'curated-sma-indo-10',
                'title' => 'Cerdas Cergas Berbahasa dan Bersastra Indonesia Kelas X',
                'authors' => ['Fadillah Tri Aulia', 'Sefi Indra Gumilar'],
                'publisher' => 'Pusat Perbukuan Kemendikbudristek RI',
                'category' => 'materi_sma',
                'subject' => 'Bahasa Indonesia',
                'class_level' => 'Kelas X',
                'description' => 'Buku teks Bahasa Indonesia SMA Kelas X Kurikulum Merdeka. Membimbing siswa menyusun laporan hasil observasi objektif, teks eksposisi analitis, teks anekdot kritis, hikayat klasik, teks negosiasi, serta analisis biografi tokoh inspiratif.',
                'cover_url' => 'https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?auto=format&fit=crop&w=600&q=80',
                'page_count' => 248,
                'published_year' => '2023',
                'is_curated' => true,
                'reader_type' => 'kemdikbud_sibi',
                'reader_url' => 'https://buku.kemendikdasmen.go.id/katalog/cerdas-cergas-berbahasa-dan-bersastra-indonesia-untuk-sma-smk-kelas-x',
                'source' => 'Kemendikbudristek SIBI',
                'language' => 'Indonesia',
                'badges' => ['Buku Resmi', 'Kelas X', 'Kurikulum Merdeka'],
            ],
            [
                'id' => 'curated-sma-ipa-10',
                'title' => 'Ilmu Pengetahuan Alam (Fisika, Kimia, Biologi) Kelas X',
                'authors' => ['Ayuk Ratna Puspaningsih', 'Elizabeth Tjahjadarmawan', 'Niken Rizki'],
                'publisher' => 'Pusat Perbukuan Kemendikbudristek RI',
                'category' => 'materi_sma',
                'subject' => 'IPA Terpadu',
                'class_level' => 'Kelas X',
                'description' => 'Buku teks IPA Terpadu Kelas X Kurikulum Merdeka. Membahas pengukuran dalam kerja ilmiah, virus dan peranannya bagi kehidupan, kimia hijau dalam pembangunan berkelanjutan, hukum dasar kimia, serta isu pemanasan global.',
                'cover_url' => 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?auto=format&fit=crop&w=600&q=80',
                'page_count' => 240,
                'published_year' => '2023',
                'is_curated' => true,
                'reader_type' => 'kemdikbud_sibi',
                'reader_url' => 'https://buku.kemendikdasmen.go.id/katalog/ilmu-pengetahuan-alam-untuk-sma-kelas-x',
                'source' => 'Kemendikbudristek SIBI',
                'language' => 'Indonesia',
                'badges' => ['Buku Resmi', 'Kelas X', 'Kurikulum Merdeka'],
            ],
            [
                'id' => 'curated-sma-sos-10',
                'title' => 'Sosiologi: Individu, Kelompok, dan Hubungan Sosial Kelas X',
                'authors' => ['Sari Oktafiana'],
                'publisher' => 'Pusat Perbukuan Kemendikbudristek RI',
                'category' => 'materi_sma',
                'subject' => 'Sosiologi',
                'class_level' => 'Kelas X',
                'description' => 'Materi pengantar sosiologi untuk SMA Kelas X. Mengupas identitas sosial, proses interaksi sosial, lembaga sosial masyarakat, serta metode penelitian sosial sederhana berbasis pengamatan lingkungan sekitar siswa.',
                'cover_url' => 'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&w=600&q=80',
                'page_count' => 208,
                'published_year' => '2023',
                'is_curated' => true,
                'reader_type' => 'kemdikbud_sibi',
                'reader_url' => 'https://buku.kemendikdasmen.go.id/katalog/sosiologi-untuk-sma-kelas-x',
                'source' => 'Kemendikbudristek SIBI',
                'language' => 'Indonesia',
                'badges' => ['Buku Resmi', 'Kelas X', 'Kurikulum Merdeka'],
            ],

            // KELAS XI
            [
                'id' => 'curated-sma-bio-11',
                'title' => 'Biologi untuk SMA Kelas XI (Kurikulum Merdeka)',
                'authors' => ['Rini Solihat', 'Eriyani', 'Widi Purwianingsih'],
                'publisher' => 'Pusat Perbukuan Kemendikbudristek RI',
                'category' => 'materi_sma',
                'subject' => 'Biologi Peminatan',
                'class_level' => 'Kelas XI',
                'description' => 'Buku Biologi SMA Kelas XI. Membahas struktur sel dan transport membran, keterkaitan struktur dan fungsi pada tumbuhan, sistem sirkulasi darah, sistem pencernaan makanan, sistem pernapasan, serta sistem ekskresi manusia.',
                'cover_url' => 'https://images.unsplash.com/photo-1530026405186-ed1f139313f8?auto=format&fit=crop&w=600&q=80',
                'page_count' => 280,
                'published_year' => '2023',
                'is_curated' => true,
                'reader_type' => 'kemdikbud_sibi',
                'reader_url' => 'https://buku.kemendikdasmen.go.id/katalog/biologi-untuk-sma-kelas-xi',
                'source' => 'Kemendikbudristek SIBI',
                'language' => 'Indonesia',
                'badges' => ['Buku Resmi', 'Kelas XI', 'Kurikulum Merdeka'],
            ],
            [
                'id' => 'curated-sma-fis-11',
                'title' => 'Fisika untuk SMA Kelas XI (Kurikulum Merdeka)',
                'authors' => ['Marianna Magdalena Radjawane', 'Almando Geraldi'],
                'publisher' => 'Pusat Perbukuan Kemendikbudristek RI',
                'category' => 'materi_sma',
                'subject' => 'Fisika Peminatan',
                'class_level' => 'Kelas XI',
                'description' => 'Buku Fisika Kelas XI Kurikulum Merdeka. Membahas vektor gerak, kinematika dan dinamika gerak lurus dan melingkar, fluida statis dan dinamis, gelombang mekanik, gelombang bunyi dan cahaya, kalor dan termodinamika.',
                'cover_url' => 'https://images.unsplash.com/photo-1636466497217-26a8cbeaf0aa?auto=format&fit=crop&w=600&q=80',
                'page_count' => 264,
                'published_year' => '2023',
                'is_curated' => true,
                'reader_type' => 'kemdikbud_sibi',
                'reader_url' => 'https://buku.kemendikdasmen.go.id/katalog/fisika-untuk-sma-kelas-xi',
                'source' => 'Kemendikbudristek SIBI',
                'language' => 'Indonesia',
                'badges' => ['Buku Resmi', 'Kelas XI', 'Kurikulum Merdeka'],
            ],
            [
                'id' => 'curated-sma-kim-11',
                'title' => 'Kimia untuk SMA Kelas XI (Kurikulum Merdeka)',
                'authors' => ['Munasprianto Ramli', 'Neneng Laksmiwati'],
                'publisher' => 'Pusat Perbukuan Kemendikbudristek RI',
                'category' => 'materi_sma',
                'subject' => 'Kimia Peminatan',
                'class_level' => 'Kelas XI',
                'description' => 'Buku Kimia Kelas XI Kurikulum Merdeka. Membahas struktur atom dan sistem periodik, ikatan kimia dan bentuk molekul, stoikiometri larutan, termokimia reaksi, laju reaksi kimia, dan kesetimbangan kimia dinamis.',
                'cover_url' => 'https://images.unsplash.com/photo-1603126857599-f6e157fa2fe6?auto=format&fit=crop&w=600&q=80',
                'page_count' => 272,
                'published_year' => '2023',
                'is_curated' => true,
                'reader_type' => 'kemdikbud_sibi',
                'reader_url' => 'https://buku.kemendikdasmen.go.id/katalog/kimia-untuk-sma-kelas-xi',
                'source' => 'Kemendikbudristek SIBI',
                'language' => 'Indonesia',
                'badges' => ['Buku Resmi', 'Kelas XI', 'Kurikulum Merdeka'],
            ],

            // KELAS XII
            [
                'id' => 'curated-sma-mat-12',
                'title' => 'Matematika untuk SMA/SMK Kelas XII (Kurikulum Merdeka)',
                'authors' => ['Mohammad Tohir', 'Ahmad Dahlan', 'Susanto'],
                'publisher' => 'Pusat Perbukuan Kemendikbudristek RI',
                'category' => 'materi_sma',
                'subject' => 'Matematika Tingkat Lanjut',
                'class_level' => 'Kelas XII',
                'description' => 'Buku Matematika Kelas XII Kurikulum Merdeka. Membahas Geometri Ruang 3 Dimensi, Transformasi Geometri, Aturan Pencacahan dan Kombinatorika, Distribusi Peluang Binomial, dan Pengantar Kalkulus Diferensial Integral.',
                'cover_url' => 'https://images.unsplash.com/photo-1596495578065-6e0763fa1178?auto=format&fit=crop&w=600&q=80',
                'page_count' => 232,
                'published_year' => '2024',
                'is_curated' => true,
                'reader_type' => 'kemdikbud_sibi',
                'reader_url' => 'https://buku.kemendikdasmen.go.id/katalog/matematika-untuk-smasmk-kelas-xii',
                'source' => 'Kemendikbudristek SIBI',
                'language' => 'Indonesia',
                'badges' => ['Buku Resmi', 'Kelas XII', 'Kurikulum Merdeka'],
            ],
            [
                'id' => 'curated-sma-eko-12',
                'title' => 'Ekonomi untuk SMA Kelas XII: Menuju Dunia Kerja & Kuliah',
                'authors' => ['Aisyah Nurjanah', 'Yeni Fitriani'],
                'publisher' => 'Pusat Perbukuan Kemendikbudristek RI',
                'category' => 'materi_sma',
                'subject' => 'Ekonomi & Akuntansi',
                'class_level' => 'Kelas XII',
                'description' => 'Materi Ekonomi SMA Kelas XII. Mengupas siklus akuntansi perusahaan jasa dan dagang, manajemen keuangan pribadi dan bisnis pemula, perdagangan internasional, neraca pembayaran, dan kebijakan ekonomi makro Indonesia.',
                'cover_url' => 'https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?auto=format&fit=crop&w=600&q=80',
                'page_count' => 224,
                'published_year' => '2024',
                'is_curated' => true,
                'reader_type' => 'kemdikbud_sibi',
                'reader_url' => 'https://buku.kemendikdasmen.go.id/katalog/ekonomi-untuk-sma-kelas-xii',
                'source' => 'Kemendikbudristek SIBI',
                'language' => 'Indonesia',
                'badges' => ['Buku Resmi', 'Kelas XII', 'Kurikulum Merdeka'],
            ],
        ];
    }
}
