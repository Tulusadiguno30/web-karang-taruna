<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Ketua (Akses Semua Modul)
        User::create([
            'name'     => 'Tulus Adiguno (Ketua)',
            'email'    => 'ketua@gmail.com',
            'password' => Hash::make('password123'),
            'role'     => 'ketua',
        ]);

        // 2. Akun Bendahara (Khusus Modul Kas & Keuangan)
        User::create([
            'name'     => 'Bendahara Kartar',
            'email'    => 'bendahara@gmail.com',
            'password' => Hash::make('password123'),
            'role'     => 'bendahara',
        ]);

        // 3. Akun Sekretaris (Khusus Modul Proker, Galeri, & Aspirasi)
        User::create([
            'name'     => 'Sekretaris Kartar',
            'email'    => 'sekretaris@gmail.com',
            'password' => Hash::make('password123'),
            'role'     => 'sekretaris',
        ]);
    }
}