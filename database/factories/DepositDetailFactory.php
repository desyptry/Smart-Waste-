<?php

namespace Database\Factories;

use App\Models\DepositDetail;
use App\Models\WasteDeposit;
use App\Models\SchedulePrice;
use Illuminate\Database\Eloquent\Factories\Factory;

class DepositDetailFactory extends Factory
{
    protected $model = DepositDetail::class;

    public function definition(): array
    {
        return [
            'waste_deposit_id' => WasteDeposit::inRandomOrder()->first()?->id ?? WasteDeposit::factory(),
            'waste_price_id' => SchedulePrice::inRandomOrder()->first()?->id ?? SchedulePrice::factory(),
            'weight_kg' => $this->faker->randomFloat(2, 0.5, 50),
            'total_price' => $this->faker->numberBetween(5000, 100000),
        ];
    }
}
