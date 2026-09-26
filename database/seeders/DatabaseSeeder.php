<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $password = Hash::make('password123'); // Password seragam untuk semua akun tes

        User::create([
            'name' => 'dzaki(Ketua)',
            'email' => 'ketua@gmail.com',
            'password' => $password,
            'role' => 'ketua',
        ]);

        User::create([
            'name' => 'Tulus(Admin)',
            'email' => 'admin@gmail.com',
            'password' => $password,
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'viona (Sekretaris)',
            'email' => 'sekretaris@gmail.com',
            'password' => $password,
            'role' => 'sekretaris',
        ]);

        User::create([
            'name' => 'Novi(Bendahara)',
            'email' => 'bendahara@gmail.com',
            'password' => $password,
            'role' => 'bendahara',
        ]);

        User::create([
            'name' => 'anggota (Anggota)',
            'email' => 'anggota@gmail.com',
            'password' => $password,
            'role' => 'anggota',
        ]);
    }
}