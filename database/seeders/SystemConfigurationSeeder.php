<?php

namespace Database\Seeders;

use App\Models\SystemConfiguration;
use Illuminate\Database\Seeder;

class SystemConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Daftar konfigurasi default/bawaan sistem SmartWaste Anda
        $configurations = [
            [
                'name' => 'app_name',
                'value' => 'SmartWaste System',
            ],
            [
                'name' => 'app_version',
                'value' => 'v1.0.0',
            ],
            [
                'name' => 'max_payout_limit',
                'value' => '200000', // Batas penarikan uang maksimal default
            ],
            [
                'name' => 'maintenance_mode',
                'value' => 'false', // Status perbaikan aplikasi
            ],
            [
                'name' => 'points_per_kg',
                'value' => '50', // Konversi poin dasar per kilogram
            ],
            [
                'name' => 'contact_email',
                'value' => 'support@smartwaste.com',
            ],
        ];

        // Looping data konfigurasi untuk dimasukkan ke database
        foreach ($configurations as $config) {
            SystemConfiguration::updateOrCreate(
                ['name' => $config['name']], // Kunci pengecekan keunikan berdasarkan kolom 'name'
                ['value' => $config['value']] // Jika nama sudah ada, nilainya akan diperbarui
            );
        }
    }
}