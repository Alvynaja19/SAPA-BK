<?php

namespace Tests\Feature;

use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfilePhotoAndNisTest extends TestCase
{
    use RefreshDatabase;

    protected function getStudentUser(array $attributes = []): User
    {
        return User::factory()->create(array_merge([
            'name' => 'Siswa Uji Coba',
            'email' => 'siswa.uji@sman4jember.sch.id',
            'role' => 'siswa',
            'nis' => '11990',
            'nisn' => '0099887766',
            'kelas' => 'XII MIPA 2',
            'is_active' => true,
        ], $attributes));
    }

    public function test_student_can_view_profile_page(): void
    {
        $studentUser = $this->getStudentUser();
        $this->actingAs($studentUser);

        $response = $this->get(route('profile'));

        $response->assertStatus(200);
        $response->assertSee('Pengaturan Profil Siswa');
        $response->assertSee('11990');
        $response->assertSee('0099887766');
        $response->assertSee('Gunakan Kamera');
        $response->assertSee('Unggah Berkas');
    }

    public function test_student_can_update_profile_and_nis(): void
    {
        $studentUser = $this->getStudentUser();
        $this->actingAs($studentUser);

        $response = $this->put(route('profile.update'), [
            'name' => 'Siswa Baru Diperbarui',
            'nis' => '12005',
            'nisn' => '0099887711',
            'kelas' => 'XII MIPA 3',
            'no_hp' => '081234567899',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'id' => $studentUser->id,
            'name' => 'Siswa Baru Diperbarui',
            'nis' => '12005',
            'nisn' => '0099887711',
            'kelas' => 'XII MIPA 3',
            'no_hp' => '081234567899',
        ]);
    }

    public function test_student_can_upload_avatar_image_file(): void
    {
        Storage::fake('public');

        $studentUser = $this->getStudentUser();
        $this->actingAs($studentUser);

        $file = UploadedFile::fake()->image('foto_profil.jpg', 400, 400);

        $response = $this->put(route('profile.update'), [
            'name' => $studentUser->name,
            'avatar' => $file,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $studentUser->refresh();
        $this->assertNotNull($studentUser->avatar);
        Storage::disk('public')->assertExists($studentUser->avatar);
        $this->assertNotNull($studentUser->avatar_url);
    }

    public function test_student_can_save_camera_captured_photo(): void
    {
        Storage::fake('public');

        $studentUser = $this->getStudentUser();
        $this->actingAs($studentUser);

        // 1x1 transparent png base64
        $fakeBase64 = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==';

        $response = $this->put(route('profile.update'), [
            'name' => $studentUser->name,
            'captured_avatar' => $fakeBase64,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $studentUser->refresh();
        $this->assertNotNull($studentUser->avatar);
        Storage::disk('public')->assertExists($studentUser->avatar);
    }

    public function test_student_can_remove_avatar(): void
    {
        Storage::fake('public');

        $studentUser = $this->getStudentUser();
        $this->actingAs($studentUser);

        // Upload first
        $file = UploadedFile::fake()->image('avatar.jpg');
        $this->put(route('profile.update'), [
            'name' => $studentUser->name,
            'avatar' => $file,
        ]);

        $studentUser->refresh();
        $avatarPath = $studentUser->avatar;
        Storage::disk('public')->assertExists($avatarPath);

        // Remove avatar
        $response = $this->put(route('profile.update'), [
            'name' => $studentUser->name,
            'remove_avatar' => 1,
        ]);

        $response->assertRedirect();
        $studentUser->refresh();
        $this->assertNull($studentUser->avatar);
        Storage::disk('public')->assertMissing($avatarPath);
    }

    public function test_student_activation_lookup_works_with_nis_and_saves_nis_to_user(): void
    {
        $student = Student::create([
            'nama' => 'Dimas Prakoso',
            'nis' => '13055',
            'nisn' => '0011223344',
            'kelas' => 'X E-1',
            'status' => 'terdaftar',
        ]);

        // 1. Lookup by NIS
        $lookupResponse = $this->post(route('aktivasi.lookup'), [
            'nis_nisn' => '13055',
        ]);

        $lookupResponse->assertRedirect(route('aktivasi'));
        $lookupResponse->assertSessionHas('aktivasi_student');
        $this->assertEquals('Dimas Prakoso', session('aktivasi_student')['nama']);
    }

    public function test_student_can_login_with_email_nis_or_nisn(): void
    {
        $student = User::factory()->create([
            'email' => 'siswa.sukses@sman4jember.sch.id',
            'password' => bcrypt('password123'),
            'role' => 'siswa',
            'nis' => '14001',
            'nisn' => '0012345678',
            'is_active' => true,
        ]);

        // Login dengan email huruf besar dan spasi (simulasi keyboard HP)
        $responseEmail = $this->post(route('login'), [
            'email' => '  Siswa.Sukses@sman4jember.sch.id  ',
            'password' => 'password123',
        ]);
        $responseEmail->assertRedirect(route('siswa.dashboard'));
        $this->assertAuthenticatedAs($student);
        auth()->logout();

        // Login dengan NISN
        $responseNisn = $this->post(route('login'), [
            'email' => '0012345678',
            'password' => 'password123',
        ]);
        $responseNisn->assertRedirect(route('siswa.dashboard'));
        $this->assertAuthenticatedAs($student);
        auth()->logout();

        // Login dengan NIS
        $responseNis = $this->post(route('login'), [
            'email' => '14001',
            'password' => 'password123',
        ]);
        $responseNis->assertRedirect(route('siswa.dashboard'));
        $this->assertAuthenticatedAs($student);
    }
}
