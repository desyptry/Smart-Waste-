<?php

namespace Database\Factories;

use App\Models\SchedulePrice; // Sesuaikan jika namanya WastePriceScadule
use App\Models\PickupSchedule;
use App\Models\WasteCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
class SchedulePriceFactory extends Factory
{
    
    protected $model = SchedulePrice::class; 

    public function definition(): array
    {
        return [
           
            'pickup_schedule_id' => PickupSchedule::factory(),
            'waste_category_id'  => WasteCategory::factory(),
            'price'              => $this->faker->numberBetween(2, 10) * 500,
        ];
    }
}