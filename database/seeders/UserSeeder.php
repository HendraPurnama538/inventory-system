<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * UserSeeder - Membuat akun admin default.
 *
 * Credentials login:
 *   Email   : admin@inventaris.com
 *   Password: password123
 */
class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@inventaris.com'],
            [
                'name'     => 'Administrator',
                'email'    => 'admin@inventaris.com',
                'phone'    => '081234567890',
                'password' => Hash::make('password123'),
            ]
        );

        $this->command->info('✅ User admin seeder selesai.');
    }
}
