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

    public function test_concurrent_login_from_second_device_is_blocked_when_first_device_is_active(): void
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
            'last_activity' => time() - 300, // Aktif 5 menit yang lalu
        ]);

        // Perangkat 2 mencoba login dengan akun yang sama
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        // Harus ditolak dan dikembalikan dengan status has_concurrent_session
        $response->assertSessionHasErrors('email');
        $response->assertSessionHas('has_concurrent_session', true);
        $this->assertGuest();

        // Pastikan sesi perangkat 1 masih utuh
        $this->assertDatabaseHas('sessions', [
            'id' => $device1SessionId,
            'user_id' => $user->id,
        ]);
    }

    public function test_guru_bk_concurrent_login_is_also_blocked_when_active_session_exists(): void
    {
        $guru = $this->createGuruBkUser();

        $device1SessionId = Str::random(40);
        DB::table('sessions')->insert([
            'id' => $device1SessionId,
            'user_id' => $guru->id,
            'ip_address' => '192.168.1.50',
            'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7)',
            'payload' => serialize(['dummy' => 'payload']),
            'last_activity' => time() - 120,
        ]);

        $response = $this->post('/login', [
            'email' => $guru->email,
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
        $response->assertSessionHas('has_concurrent_session', true);
        $this->assertGuest();
    }

    public function test_user_can_force_logout_other_devices_and_login_successfully(): void
    {
        $user = $this->createStudentUser();

        $device1SessionId = Str::random(40);
        DB::table('sessions')->insert([
            'id' => $device1SessionId,
            'user_id' => $user->id,
            'ip_address' => '192.168.1.10',
            'user_agent' => 'Perangkat Lama',
            'payload' => serialize(['dummy' => 'payload']),
            'last_activity' => time() - 100,
        ]);

        // Perangkat 2 login dengan mencentang force_logout = 1
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
            'force_logout' => 1,
        ]);

        $response->assertRedirect(route('siswa.dashboard'));
        $this->assertAuthenticatedAs($user);

        // Pastikan sesi lama perangkat 1 telah terhapus dari tabel sessions
        $this->assertDatabaseMissing('sessions', [
            'id' => $device1SessionId,
        ]);
    }

    public function test_expired_session_does_not_block_new_login(): void
    {
        $user = $this->createStudentUser();

        // Buat sesi lama yang sudah kedaluwarsa (> 120 menit lalu)
        $expiredSessionId = Str::random(40);
        DB::table('sessions')->insert([
            'id' => $expiredSessionId,
            'user_id' => $user->id,
            'ip_address' => '192.168.1.10',
            'user_agent' => 'Perangkat Lama Kedaluwarsa',
            'payload' => serialize(['dummy' => 'payload']),
            'last_activity' => time() - (150 * 60), // 150 menit lalu
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('siswa.dashboard'));
        $this->assertAuthenticatedAs($user);

        // Sesi kedaluwarsa harus sudah dibersihkan
        $this->assertDatabaseMissing('sessions', [
            'id' => $expiredSessionId,
        ]);
    }
}
