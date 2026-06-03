<?php

namespace Database\Seeders;

use App\Models\DropOffPoint;
use Illuminate\Database\Seeder;

class DropOffPointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Daftar nama posko resmi/utama untuk aplikasi SmartWaste Anda
        $points = [
            'Posko Pusat Manggarai',
            'Posko Wilayah Tebet',
            'Bank Sampah Pancoran',
            'Drop Off Point Kebayoran',
            'Gudang Sampah Senayan'
        ];

        // Looping nama-nama posko di atas, sisanya digenerate otomatis oleh factory
        foreach ($points as $pointName) {
            DropOffPoint::factory()->create([
                'name' => $pointName, // Mengunci nama posko agar tidak acak nama perusahaan fiktif
            ]);
        }
    }
}