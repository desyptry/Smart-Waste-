<?php

namespace Database\Seeders;

use App\Models\PickupSchedule;
use App\Models\OfficerDetail;
use Illuminate\Database\Seeder;

class PickupScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat 5 data petugas tiruan terlebih dahulu di tabel officer_details
        // Pastikan Anda sudah membuat OfficerDetailFactory sebelumnya
        $officers = OfficerDetail::factory()->count(5)->create();

        // 2. Buat 10 data jadwal penjemputan acak
        // Kita timpa (override) 'officer_id' menggunakan ID petugas asli yang baru saja dibuat di atas
        for ($i = 0; $i < 10; $i++) {
            PickupSchedule::factory()->create([
                'officer_id' => $officers->random()->id,
            ]);
        }
    }
}