<?php

namespace Tests\Feature;

use App\Models\Questionnaire;
use App\Models\QuestionnaireQuestion;
use App\Models\QuestionnaireResult;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestionnaireTindakLanjutTest extends TestCase
{
    use RefreshDatabase;

    public function test_guru_bk_can_view_detail_and_save_tindak_lanjut_for_student_assessment(): void
    {
        $guru = User::factory()->create(['role' => 'guru_bk', 'is_active' => true]);
        $siswa = User::factory()->create([
            'role' => 'siswa',
            'name' => 'Irma Ramadhani',
            'nisn' => '62986021',
            'kelas' => 'XII 9',
            'no_hp' => '081234567890',
            'is_active' => true,
        ]);

        $q = Questionnaire::create([
            'title' => 'Inventori Gaya Belajar Siswa (Visual, Auditori, Kinestetik)',
            'description' => 'Kuesioner gaya belajar.',
            'created_by' => $guru->id,
            'is_active' => true,
        ]);

        $soal = QuestionnaireQuestion::create([
            'questionnaire_id' => $q->id,
            'question_text' => 'Ketika guru menerangkan materi, saya lebih mudah memahami dengan:',
            'options' => [
                ['value' => 'A', 'label' => 'Melihat slide presentasi dan diagram'],
                ['value' => 'B', 'label' => 'Mendengarkan penjelasan lisan secara seksama'],
            ],
            'order' => 1,
        ]);

        $result = QuestionnaireResult::create([
            'questionnaire_id' => $q->id,
            'user_id' => $siswa->id,
            'answers' => [$soal->id => 'A'],
            'score' => 30,
        ]);

        // 1. Guru BK membuka halaman rekapitulasi hasil kuesioner
        $this->actingAs($guru);
        $rekapResp = $this->get(route('bk.tes.hasil', $q->id));
        $rekapResp->assertStatus(200);
        $rekapResp->assertSee('Irma Ramadhani');
        $rekapResp->assertSee('Tindak Lanjut');

        // 2. Guru BK mengambil detail hasil pengerjaan butir soal via API
        $detailResp = $this->getJson(route('bk.tes.hasil.detail', $result->id));
        $detailResp->assertStatus(200);
        $detailResp->assertJson([
            'success' => true,
            'data' => [
                'student_name' => 'Irma Ramadhani',
                'student_nisn' => '62986021',
                'score' => 30,
            ],
        ]);
        $detailResp->assertJsonFragment([
            'answer_value' => 'A',
            'answer_label' => 'Melihat slide presentasi dan diagram',
        ]);

        // 3. Guru BK menyimpan catatan tindak lanjut konselor
        $saveResp = $this->postJson(route('bk.tes.hasil.tindak-lanjut', $result->id), [
            'tindak_lanjut' => 'Siswa memiliki kecenderungan gaya belajar Visual. Disarankan menggunakan teknik mind-mapping dan stabilo warna.',
        ]);
        $saveResp->assertStatus(200);
        $saveResp->assertJson([
            'success' => true,
            'message' => 'Catatan tindak lanjut bimbingan berhasil disimpan!',
        ]);

        $result->refresh();
        $this->assertEquals('Siswa memiliki kecenderungan gaya belajar Visual. Disarankan menggunakan teknik mind-mapping dan stabilo warna.', $result->tindak_lanjut);
        $this->assertEquals($guru->id, $result->tindak_lanjut_by);
        $this->assertNotNull($result->tindak_lanjut_at);

        // 4. Siswa membuka lembar hasil tes dan melihat rekomendasi resmi Guru BK
        $this->actingAs($siswa);
        $siswaResp = $this->get(route('siswa.tes.hasil', $result->id));
        $siswaResp->assertStatus(200);
        $siswaResp->assertSee('Catatan Tindak Lanjut Khusus dari Guru BK:');
        $siswaResp->assertSee('teknik mind-mapping');

        // 5. Siswa melihat catatan di dashboard
        $dashboardResp = $this->get(route('siswa.dashboard'));
        $dashboardResp->assertStatus(200);
        $dashboardResp->assertSee('Catatan Guru BK:');
    }
}
