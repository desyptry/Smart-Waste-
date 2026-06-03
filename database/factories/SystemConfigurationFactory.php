<?php

namespace Database\Factories;

use App\Models\SystemConfiguration;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SystemConfiguration>
 */
class SystemConfigurationFactory extends Factory
{
    /**
     * Nama model yang terkait dengan factory ini.
     */
    protected $model = SystemConfiguration::class;

    /**
     * Tentukan status default dari blueprint data model.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Mengacak nama pengaturan tiruan yang sering ada di aplikasi
        $configName = $this->faker->unique()->randomElement([
            'app_version', 
            'max_payout_limit', 
            'maintenance_mode', 
            'contact_email',
            'points_per_kg'
        ]);

        // Memberikan nilai (value) yang sesuai dengan nama pengaturannya
        $configValue = match ($configName) {
            'app_version'      => 'v' . $this->faker->numerify('#.#.#'),
            'max_payout_limit' => (string) $this->faker->numberBetween(50000, 500000),
            'maintenance_mode' => $this->faker->randomElement(['true', 'false']),
            'contact_email'    => $this->faker->safeEmail(),
            'points_per_kg'    => (string) $this->faker->numberBetween(10, 100),
            default            => $this->faker->word(),
        };

        return [
            'name'  => $configName,
            'value' => $configValue,
        ];
    }
}