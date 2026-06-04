<?php

namespace Database\Seeders;

use App\Models\WasteDeposit;
use Illuminate\Database\Seeder;

class WasteDepositSeeder extends Seeder
{
    public function run(): void
    {
        WasteDeposit::factory()->count(20)->create();
    }
}
