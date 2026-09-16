<?php

namespace Tests\Feature;

use App\Models\ChatSession;
use App\Models\Questionnaire;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SapaBkTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_homepage_loads_successfully()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('SAPA BK');
    }

    public function test_public_pages_load_successfully()
    {
        $this->get('/tentang')->assertStatus(200);
        $this->get('/ebook')->assertStatus(200);
        $this->get('/artikel')->assertStatus(200);
        $this->get('/faq')->assertStatus(200);
        $this->get('/login')->assertStatus(200);
        $this->get('/register')->assertStatus(200);
    }

    public function test_frontend_articles_page_has_filter_and_pagination()
    {
        $response = $this->get('/artikel?category=tips_ptn');
        $response->assertStatus(200);
        $response->assertSee('Semua Topik');
        $response->assertSee('Tips Masuk PTN');

        $searchResponse = $this->get('/artikel?q=Belajar');
        $searchResponse->assertStatus(200);
    }

    public function test_siswa_can_access_dashboard_and_chat()
    {
        $siswa = User::where('role', 'siswa')->first();
        if ($siswa) {
            $this->actingAs($siswa);
            $this->get('/dashboard')->assertStatus(200);
            $this->get('/chat')->assertStatus(200);
            $this->get('/tes')->assertStatus(200);
            $this->get('/riwayat')->assertStatus(200);
        }
    }

    public function test_guru_bk_can_access_dashboard_and_modules()
    {
        $guru = User::where('role', 'guru_bk')->first();
        if ($guru) {
            $this->actingAs($guru);
            $this->get('/bk/dashboard')->assertStatus(200);
            $this->get('/bk/siswa')->assertStatus(200);
            $this->get('/bk/percakapan')->assertStatus(200);
            $this->get('/bk/live-chat')->assertStatus(200);
            $this->get('/bk/ebook')->assertStatus(200);
            $this->get('/bk/artikel')->assertStatus(200);
            $this->get('/bk/knowledge-base')->assertStatus(200);
            $this->get('/bk/tes')->assertStatus(200);
            $this->get('/bk/evaluasi')->assertStatus(200);
            $this->get('/bk/faq')->assertStatus(200);
        }
    }

    public function test_admin_can_access_dashboard_and_users()
    {
        $admin = User::where('role', 'admin')->first();
        if ($admin) {
            $this->actingAs($admin);
            $this->get('/admin/dashboard')->assertStatus(200);
            $this->get('/admin/users')->assertStatus(200);
            $this->get('/admin/konfigurasi')->assertStatus(200);
            $this->get('/admin/log')->assertStatus(200);
            $this->get('/admin/laporan')->assertStatus(200);
        }
    }

    public function test_chat_api_responds_with_context()
    {
        $siswa = User::where('role', 'siswa')->first();
        if ($siswa) {
            $this->actingAs($siswa);
            $response = $this->postJson('/api/chat', [
                'message' => 'Bagaimana cara memilih jurusan kuliah untuk SNBP?',
            ]);

            $response->assertStatus(200);
            $response->assertJson([
                'success' => true,
            ]);
            $response->assertJsonStructure([
                'success',
                'session_id',
                'user_message',
                'assistant_message' => [
                    'role',
                    'content',
                    'metadata',
                ],
            ]);
        }
    }

    public function test_siswa_can_delete_ai_chat_session()
    {
        $siswa = User::where('role', 'siswa')->where('is_active', true)->first() ?? User::factory()->create(['role' => 'siswa', 'is_active' => true]);
        $this->actingAs($siswa);

        $session = ChatSession::create([
            'user_id' => $siswa->id,
            'title' => 'Sesi Uji AI',
            'mode' => 'ai',
        ]);

        $response = $this->deleteJson('/api/chat/session/'.$session->id);
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseMissing('chat_sessions', ['id' => $session->id]);
    }

    public function test_siswa_cannot_delete_live_chat_guru_bk_session()
    {
        $siswa = User::where('role', 'siswa')->where('is_active', true)->first() ?? User::factory()->create(['role' => 'siswa', 'is_active' => true]);
        $this->actingAs($siswa);

        $session = ChatSession::create([
            'user_id' => $siswa->id,
            'title' => 'Sesi Live Chat Guru BK Terlindungi',
            'mode' => 'guru_bk',
        ]);

        // Uji via API
        $apiResponse = $this->deleteJson('/api/chat/session/'.$session->id);
        $apiResponse->assertStatus(403);
        $apiResponse->assertJson(['success' => false]);

        // Uji via Web route
        $webResponse = $this->actingAs($siswa)->delete('/riwayat/'.$session->id);
        $webResponse->assertSessionHas('error');

        // Pastikan sesi tetap ada di database
        $this->assertDatabaseHas('chat_sessions', ['id' => $session->id]);
    }

    public function test_guru_bk_can_manage_questionnaires_and_questions()
    {
        $guru = User::where('role', 'guru_bk')->first() ?? User::factory()->create(['role' => 'guru_bk', 'is_active' => true]);
        $this->actingAs($guru);

        // 1. Guru membuat kuesioner baru
        $storeResp = $this->post('/bk/tes', [
            'title' => 'Asesmen Kepribadian Holland RIASEC',
            'description' => 'Instrumen pemetaan tipe kepribadian dan lingkungan kerja masa depan.',
            'is_active' => true,
        ]);
        $storeResp->assertSessionHas('success');
        $this->assertDatabaseHas('questionnaires', ['title' => 'Asesmen Kepribadian Holland RIASEC']);

        $q = Questionnaire::where('title', 'Asesmen Kepribadian Holland RIASEC')->first();

        // 2. Guru membuka halaman kelola soal
        $soalPageResp = $this->get('/bk/tes/'.$q->id.'/soal');
        $soalPageResp->assertStatus(200);

        // 3. Guru menambah butir soal baru
        $addSoalResp = $this->post('/bk/tes/'.$q->id.'/soal', [
            'question_text' => 'Apakah kamu lebih suka merakit peralatan mekanik atau berdiskusi seni?',
            'options' => [
                ['value' => 'R', 'label' => 'Merakit dan memperbaiki alat teknis'],
                ['value' => 'A', 'label' => 'Mengekspresikan ide melalui karya seni visual'],
            ],
            'order' => 1,
        ]);
        $addSoalResp->assertSessionHas('success');
        $this->assertDatabaseHas('questionnaire_questions', [
            'questionnaire_id' => $q->id,
            'question_text' => 'Apakah kamu lebih suka merakit peralatan mekanik atau berdiskusi seni?',
        ]);

        $soal = $q->questions()->first();

        // 4. Guru mengedit butir soal
        $editSoalResp = $this->put('/bk/tes/'.$q->id.'/soal/'.$soal->id, [
            'question_text' => 'Apakah kamu lebih suka merakit alat elektronik atau menciptakan karya seni?',
            'options' => [
                ['value' => 'R', 'label' => 'Merakit dan memperbaiki peralatan elektronik'],
                ['value' => 'A', 'label' => 'Menciptakan karya seni dan ilustrasi'],
            ],
        ]);
        $editSoalResp->assertSessionHas('success');
        $this->assertDatabaseHas('questionnaire_questions', [
            'id' => $soal->id,
            'question_text' => 'Apakah kamu lebih suka merakit alat elektronik atau menciptakan karya seni?',
        ]);

        // 5. Guru menghapus butir soal
        $delSoalResp = $this->delete('/bk/tes/'.$q->id.'/soal/'.$soal->id);
        $delSoalResp->assertSessionHas('success');
        $this->assertDatabaseMissing('questionnaire_questions', ['id' => $soal->id]);

        // 6. Guru mengupdate kuesioner
        $updateQResp = $this->put('/bk/tes/'.$q->id, [
            'title' => 'Asesmen Kepribadian Holland RIASEC (Revisi)',
            'description' => 'Deskripsi diperbarui.',
            'is_active' => true,
        ]);
        $updateQResp->assertSessionHas('success');
        $this->assertDatabaseHas('questionnaires', ['title' => 'Asesmen Kepribadian Holland RIASEC (Revisi)']);

        // 7. Guru menghapus kuesioner
        $delQResp = $this->delete('/bk/tes/'.$q->id);
        $delQResp->assertRedirect(route('bk.tes'));
        $this->assertDatabaseMissing('questionnaires', ['id' => $q->id]);
    }

    public function test_siswa_cannot_manage_questionnaires_or_questions()
    {
        $siswa = User::where('role', 'siswa')->first() ?? User::factory()->create(['role' => 'siswa', 'is_active' => true]);
        $this->actingAs($siswa);

        $q = Questionnaire::first() ?? Questionnaire::create([
            'title' => 'Kuesioner Uji Akses',
            'description' => 'Deskripsi uji akses.',
            'is_active' => true,
        ]);

        // Siswa mencoba membuat kuesioner -> Ditolak (403 Forbidden)
        $this->post('/bk/tes', [
            'title' => 'Kuesioner Ilegal oleh Siswa',
            'description' => 'Tes',
        ])->assertStatus(403);

        // Siswa mencoba mengakses halaman kelola soal Guru BK -> Ditolak (403 Forbidden)
        $this->get('/bk/tes/'.$q->id.'/soal')->assertStatus(403);

        // Siswa mencoba menambah soal -> Ditolak (403 Forbidden)
        $this->post('/bk/tes/'.$q->id.'/soal', [
            'question_text' => 'Soal Ilegal',
            'options' => [['value' => 'A', 'label' => 'Opsi A'], ['value' => 'B', 'label' => 'Opsi B']],
        ])->assertStatus(403);

        // Siswa mencoba menghapus kuesioner -> Ditolak (403 Forbidden)
        $this->delete('/bk/tes/'.$q->id)->assertStatus(403);
    }

    public function test_siswa_can_view_and_update_profile()
    {
        $siswa = User::where('role', 'siswa')->first() ?? User::factory()->create(['role' => 'siswa', 'is_active' => true]);
        $this->actingAs($siswa);

        // Akses halaman profil
        $response = $this->get('/profil');
        $response->assertStatus(200);
        $response->assertSee('Pengaturan Profil Siswa');
        $response->assertSee($siswa->name);
        $response->assertSee($siswa->email);

        // Update profil siswa
        $updateResp = $this->put('/profil', [
            'name' => 'Ahmad Fauzi Pratama Update',
            'nisn' => '0054321987',
            'kelas' => 'XII MIPA 2',
            'no_hp' => '082199998888',
        ]);

        $updateResp->assertRedirect();
        $this->assertDatabaseHas('users', [
            'id' => $siswa->id,
            'name' => 'Ahmad Fauzi Pratama Update',
            'kelas' => 'XII MIPA 2',
            'no_hp' => '082199998888',
        ]);
    }
}
