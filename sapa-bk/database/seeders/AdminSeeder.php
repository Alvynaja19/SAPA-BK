<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Seed akun awal: 1 Admin, 1 Guru BK, dan 1 Siswa
     * untuk keperluan development & testing.
     */
    public function run(): void
    {
        // Administrator
        User::firstOrCreate(
            ['email' => 'admin@sapabk.sch.id'],
            [
                'name'      => 'Administrator SAPA BK',
                'password'  => Hash::make('password'),
                'role'      => 'admin',
                'is_active' => true,
            ]
        );

        // Guru BK
        User::firstOrCreate(
            ['email' => 'gurubk@sapabk.sch.id'],
            [
                'name'      => 'Guru BK Demo',
                'password'  => Hash::make('password'),
                'role'      => 'guru_bk',
                'is_active' => true,
            ]
        );

        // Siswa
        User::firstOrCreate(
            ['email' => 'siswa@sapabk.sch.id'],
            [
                'name'      => 'Siswa Demo',
                'password'  => Hash::make('password'),
                'role'      => 'siswa',
                'is_active' => true,
            ]
        );

        $this->command->info('✅ Akun demo berhasil dibuat:');
        $this->command->line('   Admin   → admin@sapabk.sch.id / password');
        $this->command->line('   Guru BK → gurubk@sapabk.sch.id / password');
        $this->command->line('   Siswa   → siswa@sapabk.sch.id / password');
    }
}
