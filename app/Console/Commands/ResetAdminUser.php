<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ResetAdminUser extends Command
{
    protected $signature = 'admin:reset {--email=admin@gmail.com} {--password=Admin123456}';

    protected $description = 'Setel ulang kredensial akun Administrator SAPA BK';

    public function handle(): int
    {
        $email = (string) $this->option('email');
        $password = (string) $this->option('password');

        $admin = User::where('role', 'admin')->first();

        if ($admin) {
            $admin->email = $email;
            $admin->password = Hash::make($password);
            $admin->is_active = true;
            $admin->save();

            $this->info('✓ Akun Administrator berhasil diperbarui:');
        } else {
            $admin = User::create([
                'name' => 'Administrator SAPA BK',
                'email' => $email,
                'password' => Hash::make($password),
                'role' => 'admin',
                'is_active' => true,
            ]);

            $this->info('✓ Akun Administrator baru berhasil dibuat:');
        }

        $this->line("  • Email    : <fg=green>{$admin->email}</>");
        $this->line("  • Password : <fg=green>{$password}</>");
        $this->line("  • Role     : <fg=green>{$admin->role}</>");
        $this->line('  • Status   : <fg=green>Aktif</>');

        return Command::SUCCESS;
    }
}
