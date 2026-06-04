<?php

namespace Database\Seeders;

use App\Models\DepositDetail;
use App\Models\WasteDeposit;
use Illuminate\Database\Seeder;

class DepositDetailSeeder extends Seeder
{
    public function run(): void
    {
        $deposits = WasteDeposit::all();

        foreach ($deposits as $deposit) {
            DepositDetail::factory()->count(rand(1, 3))->create([
                'waste_deposit_id' => $deposit->id,
            ]);
        }
    }
}
