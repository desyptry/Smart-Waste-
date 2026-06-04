<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Sistem',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('password'),
            'status' => 'active',
        ]);

        User::factory()->count(10)->create(['role' => 'citizen']);
        User::factory()->count(5)->create(['role' => 'officer']);
        User::factory()->count(3)->create(['role' => 'assesor']);
    }
}
