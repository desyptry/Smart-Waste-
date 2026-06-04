<?php
namespace Database\Seeders;
use App\Models\CitizenDetail;
use App\Models\User;
use Illuminate\Database\Seeder;

class CitizenDetailSeeder extends Seeder
{
    public function run(): void
    {
        $citizens = User::where('role', 'citizen')->get();

        foreach ($citizens as $citizen) {
            CitizenDetail::factory()->create([
                'user_id' => $citizen->id,
            ]);
        }
    }
}
