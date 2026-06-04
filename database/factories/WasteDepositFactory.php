<?php

namespace Database\Factories;

use App\Models\WasteDeposit;
use App\Models\User;
use App\Models\DropOffPoint;
use App\Models\PickupSchedule;
use Illuminate\Database\Eloquent\Factories\Factory;

class WasteDepositFactory extends Factory
{
    protected $model = WasteDeposit::class;

    public function definition(): array
    {
        return [
            'user_id' => User::where('role', 'citizen')->inRandomOrder()->first()?->id ?? User::factory(),
            'drop_off_point_id' => DropOffPoint::inRandomOrder()->first()?->id ?? DropOffPoint::factory(),
            'pickup_schedule_id' => PickupSchedule::inRandomOrder()->first()?->id ?? PickupSchedule::factory(),
            'officer_id' => User::where('role', 'officer')->inRandomOrder()->first()?->id ?? User::factory(),
            'deposit_date' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
