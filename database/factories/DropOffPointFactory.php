<?php

namespace Database\Factories;

use App\Models\DropOffPoint;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DropOffPoint>
 */
class DropOffPointFactory extends Factory
{
    /**
     * Nama model yang terkait dengan factory ini.
     */
    protected $model = DropOffPoint::class;

    /**
     * Tentukan status default dari blueprint data model.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        // Benar-benar murni angka tanpa embel-embel teks 'FK-'
        'foreignKey' => $this->faker->unique()->randomNumber(5, true),
        
        'name' => 'Drop Off Point ' . $this->faker->company(),
        'location' => $this->faker->address(),
        'latitude' => $this->faker->latitude($min = -8.0, $max = -6.0),
        'longitude' => $this->faker->longitude($min = 106.0, $max = 108.0),
    ];
    }
}