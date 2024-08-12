<?php

namespace Database\Seeders;

use App\Models\Route;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    
    public function run(): void
    {

        User::factory()->create([
            'id'=>100,
            'name' => 'Jasmin',
            'email' => 'traakkoni@example.com',
            'password'=> bcrypt('phponihanaa123'),

        ]);

        Route::factory()->create([
            'user_id' =>1,
            'name' => 'Sample Route',
            'start' => json_encode(['lat' => 60.192059, 'lng' => 24.945831]),
            'end' => json_encode(['lat' => 60.229243, 'lng' => 24.962997]),
            'waypoints' => json_encode([['lat' => 60.200000, 'lng' => 24.950000]]),
            'distance' => 10.0,
            'elevation_gain' => 100.0,
        ]);
    }
    
}
