<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\StudentProfile;
use App\Models\CounselorProfile;
use App\Models\Ebook;
use App\Models\Article;
use App\Models\Faq;
use App\Models\Questionnaire;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Seed akun awal: 1 Admin, 1 Guru BK, dan 1 Siswa
     * untuk keperluan development & testing.
     */
    public function run(): void
    {
        // Administrator
        $admin = User::firstOrCreate(
            ['email' => 'admin@sapabk.sch.id'],
            [
                'name'      => 'Administrator SAPA BK',
                'password'  => Hash::make('password'),
                'role'      => 'admin',
                'is_active' => true,
            ]
        );

        // Guru BK
        $counselor = User::firstOrCreate(
            ['email' => 'gurubk@sapabk.sch.id'],
            [
                'name'      => 'Fatimatuzzahra, S.Kom., M.Kom',
                'password'  => Hash::make('password'),
                'role'      => 'guru_bk',
                'is_active' => true,
            ]
        );
        CounselorProfile::firstOrCreate(
            ['user_id' => $counselor->id],
            [
                'nip'          => '197709292005011003',
                'spesialisasi' => 'Bimbingan Karir & Psikologi Remaja',
                'is_available' => true,
            ]
        );

        // Siswa
        $siswa = User::firstOrCreate(
            ['email' => 'siswa@sapabk.sch.id'],
            [
                'name'      => 'Mohammad Alvyn Akbar',
                'password'  => Hash::make('password'),
                'role'      => 'siswa',
                'is_active' => true,
            ]
        );
        StudentProfile::firstOrCreate(
            ['user_id' => $siswa->id],
            [
                'nisn'        => '0012345678',
                'kelas'       => 'XII MIPA 1',
                'jurusan'     => 'MIPA',
                'tahun_masuk' => 2024,
            ]
        );

        // Seed Default Ebooks if empty
        if (Ebook::count() === 0) {
            Ebook::create([
                'title'       => 'Panduan Sukses SNBP & UTBK-SNBT 2026',
                'description' => 'Strategi penentuan jurusan PTN, pemetaan kuota daya tampung, dan analisis linieritas nilai rapor siswa SMA.',
                'file_path'   => 'ebooks/panduan_snbp_2026.pdf',
                'is_public'   => true,
                'uploaded_by' => $counselor->id,
            ]);
            Ebook::create([
                'title'       => 'Manajemen Stres & Kesehatan Mental Remaja',
                'description' => 'Panduan praktis menjaga ketenangan emosi, mengatasi overthinking, dan teknik relaksasi saat menghadapi ujian.',
                'file_path'   => 'ebooks/manajemen_stres_remaja.pdf',
                'is_public'   => true,
                'uploaded_by' => $counselor->id,
            ]);
            Ebook::create([
                'title'       => 'Teknik Belajar Efektif: Pomodoro & Active Recall',
                'description' => 'Metode pembelajaran modern untuk meningkatkan konsentrasi dan daya ingat tanpa burnout.',
                'file_path'   => 'ebooks/metode_belajar_efektif.pdf',
                'is_public'   => true,
                'uploaded_by' => $counselor->id,
            ]);
        }

        // Seed Default Questionnaire if empty
        if (Questionnaire::count() === 0) {
            Questionnaire::create([
                'title'       => 'Tes Pemetaan Minat Bakat & Tipe Kepribadian (RIASEC)',
                'description' => 'Asesmen 6 tipe minat karir (Realistic, Investigative, Artistic, Social, Enterprising, Conventional) untuk menentukan pilihan jurusan kuliah.',
                'created_by'  => $counselor->id,
                'is_active'   => true,
            ]);
            Questionnaire::create([
                'title'       => 'Kuesioner Tingkat Kecemasan & Academic Burnout Siswa',
                'description' => 'Evaluasi kesehatan mental untuk mendeteksi tingkat stres akademik dan rekomendasi bimbingan.',
                'created_by'  => $counselor->id,
                'is_active'   => true,
            ]);
        }

        // Seed Default FAQ if empty
        if (Faq::count() === 0) {
            Faq::create([
                'question'  => 'Bagaimana cara berkonsultasi langsung dengan Guru BK melalui Live Chat?',
                'answer'    => 'Siswa dapat menekan tombol "Live Chat Guru BK" di dashboard atau ruang konsultasi pada jam kerja (Senin–Jumat, 08:00–15:00 WIB). Guru BK yang bertugas akan menerima antrean dan membalas secara real-time.',
                'order'     => 1,
                'is_active' => true,
            ]);
            Faq::create([
                'question'  => 'Apakah obrolan dengan Chatbot AI SAPA BK bersifat rahasia?',
                'answer'    => 'Ya, seluruh data percakapan dilindungi dengan standar privasi konseling dan hanya dapat diakses oleh siswa pemilik akun serta Tim Bimbingan Konseling SMAN 4 Jember.',
                'order'     => 2,
                'is_active' => true,
            ]);
            Faq::create([
                'question'  => 'Apakah saya bisa membuat janji konseling tatap muka di sekolah?',
                'answer'    => 'Bisa. Anda bisa menyampaikan permohonan konseling tatap muka melalui asisten chatbot atau langsung mengajukan live chat kepada Guru BK untuk menentukan waktu pertemuan di Ruang BK SMAN 4 Jember.',
                'order'     => 3,
                'is_active' => true,
            ]);
        }

        $this->command->info('✅ Data demo awal SAPA BK berhasil di-seed.');
        $this->command->line('   Admin   → admin@sapabk.sch.id / password');
        $this->command->line('   Guru BK → gurubk@sapabk.sch.id / password');
        $this->command->line('   Siswa   → siswa@sapabk.sch.id / password');
    }
}
