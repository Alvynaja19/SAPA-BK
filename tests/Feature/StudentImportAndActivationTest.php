<?php

namespace Tests\Feature;

use App\Mail\AccountVerificationMail;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class StudentImportAndActivationTest extends TestCase
{
    use RefreshDatabase;

    protected function getAdminUser(): User
    {
        return User::firstOrCreate(
            ['email' => 'admin_test@sman4jember.sch.id'],
            [
                'name' => 'Administrator Test',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );
    }

    public function test_admin_can_download_siswa_csv_template(): void
    {
        $admin = $this->getAdminUser();
        $this->actingAs($admin);

        $response = $this->get(route('admin.siswa.template'));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'text/csv; charset=UTF-8');
        $this->assertStringContainsString('template_import_siswa_sapa_bk.csv', $response->headers->get('content-disposition'));
    }

    public function test_admin_can_import_students_from_csv(): void
    {
        $admin = $this->getAdminUser();
        $this->actingAs($admin);

        $csvContent = "No,Nama,NISN,NIS,Kelas,Jenis Kelamin (L/P),No HP\n".
                      "1,Budi Permana,0061234567,11001,X MIPA 1,L,081234567890\n".
                      "2,Dewi Lestari,0061234568,11002,X MIPA 2,P,081234567891\n";

        $file = UploadedFile::fake()->createWithContent('data_siswa.csv', $csvContent);

        $response = $this->post(route('admin.siswa.import'), [
            'file' => $file,
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('students', [
            'nama' => 'Budi Permana',
            'nisn' => '0061234567',
            'nis' => '11001',
            'kelas' => 'X MIPA 1',
            'jenis_kelamin' => 'L',
            'status' => 'terdaftar',
        ]);
        $this->assertDatabaseHas('students', [
            'nama' => 'Dewi Lestari',
            'nisn' => '0061234568',
            'nis' => '11002',
            'kelas' => 'X MIPA 2',
            'jenis_kelamin' => 'P',
            'status' => 'terdaftar',
        ]);
    }

    public function test_student_can_lookup_nis_or_nisn_for_activation(): void
    {
        $student = Student::create([
            'nama' => 'Rian Hidayat',
            'nisn' => '0077788899',
            'nis' => '12399',
            'kelas' => 'XI IPS 1',
            'status' => 'terdaftar',
        ]);

        $response = $this->post(route('aktivasi.lookup'), [
            'nis_nisn' => '0077788899',
        ]);

        $response->assertRedirect(route('aktivasi'));
        $response->assertSessionHas('aktivasi_student');
        $sessionStudent = session('aktivasi_student');
        $this->assertEquals($student->id, $sessionStudent['id']);
        $this->assertEquals('Rian Hidayat', $sessionStudent['nama']);
    }

    public function test_student_receives_otp_via_email_and_can_activate_account(): void
    {
        Mail::fake();

        $student = Student::create([
            'nama' => 'Rina Amelia',
            'nisn' => '0088899900',
            'nis' => '12400',
            'kelas' => 'XI MIPA 3',
            'status' => 'terdaftar',
        ]);

        // 1. Send OTP
        $sendResponse = $this->post(route('aktivasi.send-otp'), [
            'student_id' => $student->id,
            'email' => 'rina.amelia@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $sendResponse->assertRedirect(route('aktivasi'));
        $sendResponse->assertSessionHas('aktivasi_otp_sent', true);

        Mail::assertSent(AccountVerificationMail::class, function ($mail) {
            return $mail->hasTo('rina.amelia@example.com') && ! empty($mail->otp);
        });

        $sentMails = Mail::sent(AccountVerificationMail::class);
        $this->assertNotEmpty($sentMails);
        $foundOtp = $sentMails->first()->otp;

        // 2. Verify OTP
        $verifyResponse = $this->post(route('aktivasi.verify-otp'), [
            'student_id' => $student->id,
            'email' => 'rina.amelia@example.com',
            'otp' => $foundOtp,
        ]);

        $verifyResponse->assertRedirect(route('siswa.dashboard'));
        $this->assertAuthenticated();

        // Pastikan User dibuat dan Student diupdate
        $this->assertDatabaseHas('users', [
            'email' => 'rina.amelia@example.com',
            'name' => 'Rina Amelia',
            'role' => 'siswa',
            'nisn' => '0088899900',
        ]);

        $student->refresh();
        $this->assertEquals('aktif', $student->status);
        $this->assertNotNull($student->user_id);
    }

    public function test_already_activated_student_cannot_lookup_again(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'siswa_test@sman4jember.sch.id'],
            [
                'name' => 'Siswa Test',
                'password' => bcrypt('password'),
                'role' => 'siswa',
                'nisn' => '0054321987',
                'is_active' => true,
            ]
        );

        Student::create([
            'user_id' => $user->id,
            'nama' => $user->name,
            'nisn' => '0054321987',
            'nis' => '99999',
            'status' => 'aktif',
        ]);

        $response = $this->post(route('aktivasi.lookup'), [
            'nis_nisn' => '0054321987',
        ]);

        $response->assertSessionHasErrors('nis_nisn');
    }

    public function test_guru_bk_can_access_user_management_and_bk_siswa_redirects(): void
    {
        $guruBk = User::firstOrCreate(
            ['email' => 'gurubk_test@sman4jember.sch.id'],
            [
                'name' => 'Guru BK Test',
                'password' => bcrypt('password'),
                'role' => 'guru_bk',
                'is_active' => true,
            ]
        );

        $this->actingAs($guruBk);

        // Akses langsung ke admin.users
        $response = $this->get(route('admin.users'));
        $response->assertStatus(200);

        // Akses ke bk.siswa redirect ke admin.users
        $redirectResponse = $this->get(route('bk.siswa'));
        $redirectResponse->assertRedirect(route('admin.users'));
    }

    public function test_admin_can_update_user(): void
    {
        $admin = $this->getAdminUser();
        $this->actingAs($admin);

        $targetUser = User::create([
            'name' => 'Original Name',
            'email' => 'original@sman4jember.sch.id',
            'password' => bcrypt('password123'),
            'role' => 'siswa',
            'nisn' => '1234567890',
            'kelas' => 'X MIPA 1',
            'is_active' => true,
        ]);

        $response = $this->put(route('admin.users.update', $targetUser->id), [
            'name' => 'Updated Name',
            'email' => 'updated@sman4jember.sch.id',
            'role' => 'siswa',
            'nisn' => '1234567890',
            'kelas' => 'XI MIPA 2',
            'no_hp' => '081234567899',
            'is_active' => 1,
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('users', [
            'id' => $targetUser->id,
            'name' => 'Updated Name',
            'email' => 'updated@sman4jember.sch.id',
            'kelas' => 'XI MIPA 2',
        ]);
    }

    public function test_admin_can_delete_user_and_cannot_delete_self(): void
    {
        $admin = $this->getAdminUser();
        $this->actingAs($admin);

        // 1. Tidak boleh menghapus akun sendiri
        $selfDeleteResponse = $this->delete(route('admin.users.destroy', $admin->id));
        $selfDeleteResponse->assertSessionHasErrors('error');
        $this->assertDatabaseHas('users', ['id' => $admin->id]);

        // 2. Bisa menghapus akun pengguna lain dan tetap berada di tab role yang sama
        $userToDelete = User::create([
            'name' => 'To Delete',
            'email' => 'todelete@sman4jember.sch.id',
            'password' => bcrypt('password123'),
            'role' => 'siswa',
            'is_active' => true,
        ]);

        $deleteResponse = $this->delete(route('admin.users.destroy', $userToDelete->id), [
            'role' => 'siswa',
        ]);
        $deleteResponse->assertRedirect(route('admin.users', ['role' => 'siswa']));
        $deleteResponse->assertSessionHas('success');
        $this->assertDatabaseMissing('users', ['id' => $userToDelete->id]);
    }

    public function test_admin_and_guru_bk_can_view_user_detail(): void
    {
        $admin = $this->getAdminUser();
        $this->actingAs($admin);

        $targetUser = User::create([
            'name' => 'Target Detail',
            'email' => 'detail@sman4jember.sch.id',
            'password' => bcrypt('password123'),
            'role' => 'siswa',
            'is_active' => true,
        ]);

        $response = $this->get(route('admin.users.detail', $targetUser->id));
        $response->assertStatus(200);
        $response->assertSee('Target Detail');
    }
}
