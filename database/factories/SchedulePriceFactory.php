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
            'type_name'          => $this->faker->randomElement(['Botol Plastik PET', 'Kardus Box', 'Kaleng Alumunium']),
            'price'              => $this->faker->numberBetween(2, 10) * 500,
            'rules'              => 'Harus dalam keadaan kosong dan bersih.',
            'description'        => 'Harga khusus setoran terjadwal posko.',
            'photo'              => 'sample_waste_' . $this->faker->word() . '.jpg',
        ];
    }
}