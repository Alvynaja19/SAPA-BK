<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ChatMessage;
use App\Models\ChatSession;
use App\Models\Ebook;
use App\Models\Faq;
use App\Models\KnowledgeDocument;
use App\Models\Questionnaire;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Administrator
        $admin = User::create([
            'name' => 'Administrator SAPA BK',
            'email' => 'admin@sman4jember.sch.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // 2. Akun Guru BK
        $guruBk = User::create([
            'name' => 'Dra. Hj. Siti Rahayu, M.Pd.',
            'email' => 'gurubk@sman4jember.sch.id',
            'password' => Hash::make('password'),
            'role' => 'guru_bk',
            'no_hp' => '081234567890',
            'is_active' => true,
        ]);

        // 3. Akun Siswa Teladan
        $siswa = User::create([
            'name' => 'Ahmad Fauzi Pratama',
            'email' => 'siswa@sman4jember.sch.id',
            'password' => Hash::make('password'),
            'role' => 'siswa',
            'nisn' => '0054321987',
            'kelas' => 'XII MIPA 1',
            'no_hp' => '082198765432',
            'is_active' => true,
        ]);

        // 4. FAQ Utama
        $faqs = [
            [
                'question' => 'Apa itu SAPA BK SMA Negeri 4 Jember?',
                'answer' => 'SAPA BK (Sistem Asisten Pendamping Akademik & BK) adalah inovasi portal digital SMA Negeri 4 Jember yang menyediakan layanan konseling cerdas berbasis AI (RAG), akses e-book panduan karir, artikel edukatif, kuesioner peminatan, serta penjadwalan konseling tatap muka dengan Guru BK.',
                'order' => 1,
            ],
            [
                'question' => 'Apakah percakapan saya dengan asisten AI dan Guru BK dirahasiakan?',
                'answer' => 'Ya, asas kerahasiaan adalah kode etik utama bimbingan dan konseling. Seluruh data percakapan tersimpan secara terenkripsi dan hanya dapat diakses oleh Guru BK yang berwenang untuk tujuan pendampingan belajar dan kesejahteraan siswa.',
                'order' => 2,
            ],
            [
                'question' => 'Bagaimana cara berkonsultasi mengenai pemilihan jurusan SNBP dan SNBT?',
                'answer' => 'Kamu bisa menanyakan langsung melalui chatbot SAPA BK untuk mendapatkan panduan dasar pemetaan mata pelajaran pendukung, lalu jadwalkan sesi konseling mendalam dengan Guru BK melalui fitur Live Chat atau janji temu di ruang BK.',
                'order' => 3,
            ],
            [
                'question' => 'Siapa saja yang dapat mengakses layanan e-book di SAPA BK?',
                'answer' => 'Terdapat e-book publik yang dapat diakses oleh siapa saja tanpa login, serta e-book khusus siswa dan modul bimbingan yang dapat dibaca dan diunduh lengkap setelah siswa login.',
                'order' => 4,
            ],
            [
                'question' => 'Bagaimana jika saya mengalami kendala perundungan (bullying) atau masalah pribadi?',
                'answer' => 'Segera hubungi Guru BK melalui portal SAPA BK atau datang langsung ke ruang BK SMAN 4 Jember. Guru BK siap menjadi sahabat dan pendamping yang aman tanpa menghakimi.',
                'order' => 5,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }

        // 5. E-Book Bimbingan Konseling
        $ebooks = [
            [
                'title' => 'Panduan Sukses Menembus PTN Impian (SNBP & SNBT 2026)',
                'description' => 'Strategi komprehensif pemilihan program studi, analisis nilai rapor, dan tips belajar menghadapi ujian seleksi nasional masuk perguruan tinggi.',
                'file_path' => 'ebooks/panduan_ptn_2026.pdf',
                'cover_path' => 'saasable/images/blog/blog-1.jpg',
                'is_public' => true,
                'uploaded_by' => $guruBk->id,
            ],
            [
                'title' => 'Manajemen Stres & Regulasi Emosi Siswa Remaja',
                'description' => 'Modul praktis mengatasi kejenuhan belajar (burnout), teknik relaksasi pernapasan, serta kiat membangun ketangguhan mental di sekolah.',
                'file_path' => 'ebooks/manajemen_stres.pdf',
                'cover_path' => 'saasable/images/blog/blog-2.jpg',
                'is_public' => true,
                'uploaded_by' => $guruBk->id,
            ],
            [
                'title' => 'Eksplorasi Minat, Bakat, dan Perencanaan Karir Abad 21',
                'description' => 'Mengenali potensi diri, tes tipe kepribadian, serta peta kebutuhan profesi masa depan untuk siswa jenjang SMA.',
                'file_path' => 'ebooks/eksplorasi_karir.pdf',
                'cover_path' => 'saasable/images/blog/blog-3.jpg',
                'is_public' => false,
                'uploaded_by' => $guruBk->id,
            ],
            [
                'title' => 'Panduan Komunikasi Asertif dan Anti-Perundungan di Lingkungan Sekolah',
                'description' => 'Panduan bagi siswa untuk saling menghargai, membangun empati, dan langkah berani melapor saat melihat atau mengalami perundungan.',
                'file_path' => 'ebooks/komunikasi_asertif.pdf',
                'cover_path' => 'saasable/images/blog/blog-4.jpg',
                'is_public' => false,
                'uploaded_by' => $guruBk->id,
            ],
        ];

        foreach ($ebooks as $eb) {
            Ebook::create($eb);
        }

        // 6. Artikel Edukatif
        $articles = [
            [
                'title' => '5 Tips Menentukan Pilihan Jurusan Kuliah Sesuai Minat & Peluang Karir',
                'slug' => '5-tips-menentukan-pilihan-jurusan-kuliah',
                'content' => '<p>Memilih jurusan kuliah bukanlah keputusan instan. Banyak siswa yang merasa bingung saat mendekati kelulusan. Berikut adalah 5 langkah strategis yang direkomendasikan oleh Guru BK SMA Negeri 4 Jember:</p><ul><li><strong>Kenali Minat dan Bakat:</strong> Ikuti tes inventori minat bakat yang disediakan di SAPA BK.</li><li><strong>Riset Mata Kuliah & Prospek Kerja:</strong> Jangan hanya terpaku pada nama jurusan, pelajari kurikulumnya.</li><li><strong>Konsultasikan dengan Guru BK & Orang Tua:</strong> Diskusikan ekspektasi dan kesiapan finansial serta emosional.</li><li><strong>Cek Keketatan & Kuota SNBP/SNBT:</strong> Analisis tren penerimaan tahun-tahun sebelumnya di SMAN 4 Jember.</li><li><strong>Pilih dengan Yakin:</strong> Keberhasilan di perguruan tinggi ditentukan oleh komitmen dan konsistensi belajar.</li></ul>',
                'thumbnail' => 'saasable/images/blog/blog-1.jpg',
                'is_published' => true,
                'author_id' => $guruBk->id,
            ],
            [
                'title' => 'Menjaga Kesehatan Mental di Tengah Padatnya Ujian dan Tugas Sekolah',
                'slug' => 'menjaga-kesehatan-mental-siswa-sma',
                'content' => '<p>Kesehatan mental sama pentingnya dengan kesehatan fisik. Beban akademik yang menumpuk kerap memicu kecemasan berlebih. Siswa disarankan untuk menjaga pola tidur 7-8 jam per hari, meluangkan waktu rehat tanpa gawai, serta aktif berbagi cerita dengan rekan sebaya atau konselor sekolah ketika merasa terbebani.</p>',
                'thumbnail' => 'saasable/images/blog/blog-2.jpg',
                'is_published' => true,
                'author_id' => $guruBk->id,
            ],
            [
                'title' => 'Pentingnya Membangun Circle Pertemanan yang Sehat dan Positif di SMA',
                'slug' => 'circle-pertemanan-sehat-dan-positif-sma',
                'content' => '<p>Lingkungan pertemanan sangat memengaruhi motivasi belajar dan pembentukan karakter remaja. Lingkungan yang suportif akan mendorong prestasi dan menghindarkan dari bahaya kenakalan remaja atau perundungan.</p>',
                'thumbnail' => 'saasable/images/blog/blog-3.jpg',
                'is_published' => true,
                'author_id' => $guruBk->id,
            ],
        ];

        foreach ($articles as $art) {
            Article::create($art);
        }

        // 7. Dokumen Knowledge Base RAG
        KnowledgeDocument::create([
            'title' => 'Panduan Layanan BK & Kode Etik Bimbingan Konseling SMAN 4 Jember 2026',
            'file_path' => 'knowledge_docs/panduan_bk_sman4.pdf',
            'status' => 'indexed',
            'indexed_at' => now(),
            'uploaded_by' => $guruBk->id,
        ]);

        KnowledgeDocument::create([
            'title' => 'Pedoman SNPMB & Regulasi Kurikulum Merdeka Fase F',
            'file_path' => 'knowledge_docs/pedoman_snpmb_2026.pdf',
            'status' => 'indexed',
            'indexed_at' => now(),
            'uploaded_by' => $guruBk->id,
        ]);

        // 8. Kuesioner Contoh (Tes Gaya Belajar VAK)
        Questionnaire::create([
            'title' => 'Inventori Gaya Belajar Siswa (Visual, Auditori, Kinestetik)',
            'description' => 'Kuesioner ini membantu siswa mengetahui gaya belajar dominan agar strategi menyerap pelajaran di kelas menjadi lebih efektif dan menyenangkan.',
            'created_by' => $guruBk->id,
            'is_active' => true,
        ]);

        $this->call(QuestionnaireQuestionSeeder::class);

        // 9. Contoh Sesi Percakapan Awal Siswa
        $session = ChatSession::create([
            'user_id' => $siswa->id,
            'title' => 'Tanya Prospek Jurusan Kedokteran & Teknik',
        ]);

        ChatMessage::create([
            'session_id' => $session->id,
            'role' => 'user',
            'content' => 'Halo Ibu/Bapak Guru BK, saya masih bimbang antara memilih Kedokteran atau Teknik Informatika untuk SNBP nanti. Bagaimana cara menentukan prioritasnya?',
        ]);

        ChatMessage::create([
            'session_id' => $session->id,
            'role' => 'assistant',
            'content' => 'Halo Ahmad! Kedua jurusan tersebut memiliki prospek yang sangat cerah namun membutuhkan kekuatan mata pelajaran yang berbeda. Untuk Kedokteran, nilai Biologi, Kimia, dan Bahasa Inggris menjadi fokus utama. Sedangkan Teknik Informatika menitikberatkan pada Matematika Tingkat Lanjut, Fisika, dan logika algoritma. Rekomendasi kami: buka modul panduan PTN di menu E-book, lalu silakan buat janji tatap muka di ruang BK untuk melihat sebaran alumni SMAN 4 Jember di kedua prodi tersebut.',
            'metadata' => [
                'sources' => ['Pedoman SNPMB SMAN 4 Jember', 'Peta Minat Karir Siswa SMA'],
                'recommended_ebooks' => [
                    [
                        'id' => 1,
                        'title' => 'Panduan Sukses Menembus PTN Impian (SNBP & SNBT 2026)',
                        'url' => '/ebook/1',
                    ],
                ],
            ],
        ]);
    }
}
