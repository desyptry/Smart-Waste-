<?php

namespace Database\Seeders;

use App\Models\Withdrawal;
use Illuminate\Database\Seeder;

class WithdrawalSeeder extends Seeder
{
    public function run(): void
    {
        Withdrawal::factory()->count(15)->create();
    }
}
