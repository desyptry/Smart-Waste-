<?php

namespace Database\Seeders;

use App\Models\SchedulePrice;
use App\Models\WasteCategory;
use Illuminate\Database\Seeder;

class SchedulePriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Ambil semua data kategori sampah yang sudah kita seed sebelumnya
        $categories = WasteCategory::all();

        // Antisipasi jika seeder kategori belum dijalankan
        if ($categories->isEmpty()) {
            $this->command->warn('Tabel waste_categories kosong! Jalankan WasteCategorySeeder terlebih dahulu.');
            return;
        }

        //Kita buat data harga jadwal sampah sebanyak 15 data
        // Kita timpa (override) 'waste_category_id' agar menggunakan ID kategori yang asli secara acak
        for ($i = 0; $i < 15; $i++) {
            SchedulePrice::factory()->create([
                'waste_category_id' => $categories->random()->id,
            ]);
        }
    }
}