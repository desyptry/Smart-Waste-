<?php

namespace Database\Seeders;

use App\Models\WasteCategory;
use Illuminate\Database\Seeder;

class WasteCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $categories = ['Plastik', 'Kertas/Karton', 'Kaca', 'Logam/Besi', 'Elektronik', 'Organik'];

        
        foreach ($categories as $category) {
            WasteCategory::factory()->create([
                'name' => $category, 
            ]);
        }
    }
}