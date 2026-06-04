<?php

namespace Database\Factories;

use App\Models\Withdrawal;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class WithdrawalFactory extends Factory
{
    protected $model = Withdrawal::class;

    public function definition(): array
    {
        $status = $this->faker->randomElement(['pending', 'approved', 'rejected']);

        return [
            'user_id' => User::where('role', 'citizen')->inRandomOrder()->first()?->id ?? User::factory(),
            'asessor_id' => User::where('role', 'assesor')->inRandomOrder()->first()?->id ?? User::factory(),
            'amount' => $this->faker->randomFloat(2, 50000, 1000000),
            'method' => $this->faker->randomElement(['bank_transfer', 'e_wallet']),
            'account_name' => $this->faker->name(),
            'account_number' => $this->faker->bankAccountNumber(),
            'status' => $status,
            'approved_at' => $status === 'approved' ? $this->faker->dateTimeBetween('-2 weeks', 'now') : null,
        ];
    }
}
