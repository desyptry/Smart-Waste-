<?php
namespace Database\Factories;
use App\Models\OfficerDetail;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OfficerDetailFactory extends Factory
{
    protected $model = OfficerDetail::class;

    public function definition(): array
    {
        return [
            'user_id' => User::where('role', 'officer')->inRandomOrder()->first()?->id ?? User::factory(),
            'collection_point_id' => \App\Models\DropOffPoint::inRandomOrder()->first()?->id ?? \App\Models\DropOffPoint::factory(),
        ];
    }
}
