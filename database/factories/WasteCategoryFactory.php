<?php

namespace Database\Factories;

use App\Models\WasteCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class WasteCategoryFactory extends Factory
{

    protected $model = WasteCategory::class;

    /**
     * Tentukan status default dari blueprint data model.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        $categories = ['Plastik', 'Kertas/Karton', 'Kaca', 'Logam/Besi', 'Elektronik', 'Organik'];

        return [
            
            'name' => $this->faker->unique()->randomElement($categories),
            'description' => 'Kategori sampah jenis ' . $this->faker->sentence(4),  
            'photo' => 'waste_' . $this->faker->word() . '.jpg',           
            'rules' => 'Pastikan dalam keadaan bersih dan ' . $this->faker->randomElement(['kering', 'tidak tercampur', 'dipres']),
        ];
    }
}