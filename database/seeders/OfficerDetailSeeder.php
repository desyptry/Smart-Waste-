<?php

namespace Database\Seeders;

use App\Models\OfficerDetail;
use App\Models\User;
use Illuminate\Database\Seeder;

class OfficerDetailSeeder extends Seeder
{
    public function run(): void
    {
        $officers = User::where('role', 'officer')->get();

        foreach ($officers as $officer) {
            OfficerDetail::factory()->create([
                'user_id' => $officer->id,
            ]);
        }
    }
}
