<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat 1 Akun Super Admin
        User::create([
            'name' => 'Super Admin IPNU',
            'email' => 'admin@ipnu.com',
            'password' => Hash::make('password'), // Password admin
            'role' => 'admin',
        ]);

        // Kita tidak perlu buat dummy user lain dulu
    }
}