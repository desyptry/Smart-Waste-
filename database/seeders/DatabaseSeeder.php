<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // 2. Barisan Panggilan Seeder Terstruktur (Sangat Aman & Rapi!)
        $this->call([
                    UserSeeder::class,
            SystemConfigurationSeeder::class, // 1. Bikin Konfigurasi Sistem Bawaan
            WasteCategorySeeder::class,       // 2. Bikin Kategori Master (Plastik, Kaca, dll)
            DropOffPointSeeder::class,        // 3. Bikin Posko Induk (Manggarai, Tebet, dll)
            PickupScheduleSeeder::class,      // 4. Bikin Petugas & Jadwal Penjemputan
            SchedulePriceSeeder::class,  // 5. Bikin Harga khusus berdasarkan Jadwal & Kategori
               
            OfficerDetailSeeder::class,
            CitizenDetailSeeder::class,
            WasteDepositSeeder::class,
            DepositDetailSeeder::class,
            WithdrawalSeeder::class,
        ]);
    }
}