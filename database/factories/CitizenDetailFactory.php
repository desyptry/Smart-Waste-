<?php
namespace Database\Factories;
use App\Models\CitizenDetail;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CitizenDetailFactory extends Factory
{
    protected $model = CitizenDetail::class;

    public function definition(): array
    {
        return [
            'user_id' => User::where('role', 'citizen')->inRandomOrder()->first()?->id ?? User::factory(),
            'balance' => $this->faker->numberBetween(10000, 500000),
        ];
    }
}
