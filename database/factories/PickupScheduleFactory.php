<?php

namespace Database\Factories;

use App\Models\PickupSchedule;
use App\Models\DropOffPoint; // Menggunakan model posko Anda yang sudah aktif kemarin
use App\Models\OfficerDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PickupSchedule>
 */
class PickupScheduleFactory extends Factory
{
    /**
     * Nama model yang terkait dengan factory ini.
     */
    protected $model = PickupSchedule::class;

    /**
     * Tentukan status default dari blueprint data model.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        $startDate = $this->faker->dateTimeBetween('now', '+7 days');
        
        
        $finishDate = clone $startDate;
        $finishDate->modify('+4 hours');

        return [
           
            'officer_id' => 1, 
            
            
            'collection_point_id' => function () {
    // Mengambil satu ID posko yang sudah ada di database secara acak
    return \App\Models\DropOffPoint::inRandomOrder()->first()?->id ?? \App\Models\DropOffPoint::factory();
},
            
            'start_date' => $startDate,
            'finish_date' => $finishDate,
        ];
    }
}