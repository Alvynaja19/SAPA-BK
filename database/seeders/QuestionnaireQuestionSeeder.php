<?php

namespace Database\Seeders;

use App\Models\Questionnaire;
use App\Models\QuestionnaireQuestion;
use Illuminate\Database\Seeder;

class QuestionnaireQuestionSeeder extends Seeder
{
    public function run(): void
    {
        $q = Questionnaire::first();
        if ($q && $q->questions()->count() === 0) {
            QuestionnaireQuestion::create([
                'questionnaire_id' => $q->id,
                'question_text' => 'Ketika guru menjelaskan materi baru di kelas, cara mana yang paling membantumu memahaminya dengan cepat?',
                'options' => [
                    ['value' => 'visual', 'label' => 'Melihat diagram, infografis warna-warni, atau tulisan di papan tulis / proyektor (Visual).'],
                    ['value' => 'auditori', 'label' => 'Mendengarkan penjelasan lisan secara seksama atau berdiskusi langsung (Auditori).'],
                    ['value' => 'kinestetik', 'label' => 'Langsung mencoba latihan soal, praktikum, atau mencatat sambil bergerak (Kinestetik).'],
                ],
                'order' => 1,
            ]);

            QuestionnaireQuestion::create([
                'questionnaire_id' => $q->id,
                'question_text' => 'Saat menghafal rumus atau kosakata bahasa asing, apa yang biasa kamu lakukan?',
                'options' => [
                    ['value' => 'visual', 'label' => 'Membayangkan tulisan kata atau letak rumus di halaman buku catatan.'],
                    ['value' => 'auditori', 'label' => 'Mengucapkannya berulang-ulang dengan suara keras atau membuat nyanyian/irama.'],
                    ['value' => 'kinestetik', 'label' => 'Menulis berulang kali di kertas coretan atau mondar-mandir saat menghafal.'],
                ],
                'order' => 2,
            ]);

            QuestionnaireQuestion::create([
                'questionnaire_id' => $q->id,
                'question_text' => 'Di waktu luang atau saat istirahat sekolah, kegiatan apa yang paling kamu sukai?',
                'options' => [
                    ['value' => 'visual', 'label' => 'Membaca buku komik/novel, menonton video edukasi, atau menggambar sketsa.'],
                    ['value' => 'auditori', 'label' => 'Mendengarkan podcast/musik atau mengobrol asyik dengan teman sebangku.'],
                    ['value' => 'kinestetik', 'label' => 'Berolahraga (basket/futsal), jalan-jalan ke kantin, atau membuat prakarya tangan.'],
                ],
                'order' => 3,
            ]);
        }
    }
}
