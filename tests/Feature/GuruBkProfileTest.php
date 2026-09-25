<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class GuruBkProfileTest extends TestCase
{
    use RefreshDatabase;

    protected function getGuruBkUser(array $attributes = []): User
    {
        return User::factory()->create(array_merge([
            'name' => 'Habibie S.T',
            'email' => 'habibie.bk@sman4jember.sch.id',
            'role' => 'guru_bk',
            'no_hp' => '081234567890',
            'is_active' => true,
        ], $attributes));
    }

    protected function getStudentUser(array $attributes = []): User
    {
        return User::factory()->create(array_merge([
            'name' => 'Siswa Test',
            'email' => 'siswa.test@sman4jember.sch.id',
            'role' => 'siswa',
            'nis' => '12345',
            'nisn' => '0012345678',
            'kelas' => 'XI MIPA 1',
            'is_active' => true,
        ], $attributes));
    }

    public function test_guru_bk_can_view_bk_profile_page_within_dashboard(): void
    {
        $guruBk = $this->getGuruBkUser();
        $this->actingAs($guruBk);

        $response = $this->get(route('bk.profile'));

        $response->assertStatus(200);
        $response->assertSee('Profil Akun Guru BK');
        $response->assertSee('Habibie S.T');
        $response->assertSee('habibie.bk@sman4jember.sch.id');
        $response->assertSee('081234567890');
        $response->assertSee('Dashboard BK');
        $response->assertSee('Gunakan Kamera');
        $response->assertSee('Unggah Berkas');
        // Ensure student-specific headers/fields are not present
        $response->assertDontSee('Profil Akun Siswa');
        $response->assertDontSee('Nomor Induk Siswa Nasional (NISN)');
    }

    public function test_guru_bk_accessing_global_profil_route_is_redirected_to_bk_profile(): void
    {
        $guruBk = $this->getGuruBkUser();
        $this->actingAs($guruBk);

        $response = $this->get(route('profile'));

        $response->assertRedirect(route('bk.profile'));
    }

    public function test_guru_bk_can_update_profile_info(): void
    {
        $guruBk = $this->getGuruBkUser();
        $this->actingAs($guruBk);

        $response = $this->from(route('bk.profile'))->put(route('profile.update'), [
            'name' => 'Habibie S.T, M.Pd',
            'no_hp' => '089876543210',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertRedirect(route('bk.profile'));
        $response->assertSessionHas('success');

        $guruBk->refresh();
        $this->assertEquals('Habibie S.T, M.Pd', $guruBk->name);
        $this->assertEquals('089876543210', $guruBk->no_hp);
        $this->assertTrue(Hash::check('newpassword123', $guruBk->password));
    }

    public function test_student_still_views_student_profile_at_global_profil_route(): void
    {
        $student = $this->getStudentUser();
        $this->actingAs($student);

        $response = $this->get(route('profile'));

        $response->assertStatus(200);
        $response->assertSee('Pengaturan Profil Siswa');
        $response->assertSee('12345');
        $response->assertSee('0012345678');
    }

    public function test_student_cannot_access_guru_bk_profile(): void
    {
        $student = $this->getStudentUser();
        $this->actingAs($student);

        $response = $this->get(route('bk.profile'));

        // role middleware will forbid or redirect student
        $this->assertTrue(in_array($response->status(), [403, 302]));
    }
}
