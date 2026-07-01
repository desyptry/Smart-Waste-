<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Data Detail untuk Admin
        User::create([
            'name' => 'Admin Sistem',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('password'),
            'status' => 'active',
        ]);

        // 2. Data Detail untuk Citizen (Masyarakat)
        User::create([
            'name' => 'Warga Budiman',
            'email' => 'citizen@gmail.com',
            'role' => 'citizen',
            'password' => Hash::make('password'),
            'status' => 'active',
        ]);

        // 3. Data Detail untuk Officer (Petugas)
        User::create([
            'name' => 'Petugas Lapangan',
            'email' => 'officer@gmail.com',
            'role' => 'officer',
            'password' => Hash::make('password'),
            'status' => 'active',
        ]);

        // 4. Data Detail untuk Assesor (Penilai)
        User::create([
            'name' => 'Tim Assesor',
            'email' => 'assesor@gmail.com',
            'role' => 'assesor',
            'password' => Hash::make('password'),
            'status' => 'active',
        ]);
    }
}
