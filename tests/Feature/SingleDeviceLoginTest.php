<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class SingleDeviceLoginTest extends TestCase
{
    use RefreshDatabase;

    protected function createStudentUser(array $attributes = []): User
    {
        return User::factory()->create(array_merge([
            'name' => 'Siswa Test Device',
            'email' => 'siswa.device@sman4jember.sch.id',
            'password' => Hash::make('password123'),
            'role' => 'siswa',
            'nis' => '12345',
            'nisn' => '0012345678',
            'is_active' => true,
        ], $attributes));
    }

    protected function createGuruBkUser(array $attributes = []): User
    {
        return User::factory()->create(array_merge([
            'name' => 'Guru BK Test Device',
            'email' => 'gurubk.device@sman4jember.sch.id',
            'password' => Hash::make('password123'),
            'role' => 'guru_bk',
            'is_active' => true,
        ], $attributes));
    }

    public function test_user_can_login_normally_when_no_active_session_exists(): void
    {
        $user = $this->createStudentUser();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('siswa.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_new_login_automatically_logs_out_previous_device_session_for_student(): void
    {
        $user = $this->createStudentUser();

        // Simulasikan sesi aktif perangkat 1 di database
        $device1SessionId = Str::random(40);
        DB::table('sessions')->insert([
            'id' => $device1SessionId,
            'user_id' => $user->id,
            'ip_address' => '192.168.1.10',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0',
            'payload' => serialize(['dummy' => 'payload']),
            'last_activity' => time() - 300,
        ]);

        // Perangkat 2 login dengan akun yang sama (Opsi 1: langsung berhasil masuk)
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('siswa.dashboard'));
        $this->assertAuthenticatedAs($user);

        // Pastikan sesi perangkat lama (perangkat 1) telah otomatis dihapus dari database
        $this->assertDatabaseMissing('sessions', [
            'id' => $device1SessionId,
        ]);
    }

    public function test_new_login_automatically_logs_out_previous_device_session_for_guru_bk(): void
    {
        $guru = $this->createGuruBkUser();

        // Simulasikan sesi aktif guru BK di perangkat 1
        $device1SessionId = Str::random(40);
        DB::table('sessions')->insert([
            'id' => $device1SessionId,
            'user_id' => $guru->id,
            'ip_address' => '192.168.1.50',
            'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7)',
            'payload' => serialize(['dummy' => 'payload']),
            'last_activity' => time() - 120,
        ]);

        // Guru BK login di perangkat 2
        $response = $this->post('/login', [
            'email' => $guru->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('bk.dashboard'));
        $this->assertAuthenticatedAs($guru);

        // Sesi perangkat 1 otomatis terhapus
        $this->assertDatabaseMissing('sessions', [
            'id' => $device1SessionId,
        ]);
    }

    public function test_remember_token_is_rotated_on_new_login_to_invalidate_old_device_auto_login(): void
    {
        $oldRememberToken = Str::random(60);
        $user = $this->createStudentUser([
            'remember_token' => $oldRememberToken,
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $user->refresh();
        $this->assertNotEquals($oldRememberToken, $user->remember_token);
    }
}
