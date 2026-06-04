<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'role' => $this->faker->randomElement(['admin', 'citizen', 'officer', 'assesor']),
            'address' => $this->faker->address(),
            'phone_number' => $this->faker->phoneNumber(),
            'profile_picture' => null,
            'status' => 'active',
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }
}
