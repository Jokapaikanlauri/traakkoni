<?php

namespace Database\Factories;

use App\Models\Route;
use Illuminate\Database\Eloquent\Factories\Factory;

class RouteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Route::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(), // Assuming each route is associated with a user
            'name' => $this->faker->words(3, true), // Generates a random name
            'start' => json_encode([
                'lat' => $this->faker->latitude,
                'lng' => $this->faker->longitude
            ]), // Generates random coordinates for start
            'end' => json_encode([
                'lat' => $this->faker->latitude,
                'lng' => $this->faker->longitude
            ]), // Generates random coordinates for end
            'waypoints' => json_encode([
                ['lat' => $this->faker->latitude, 'lng' => $this->faker->longitude],
                ['lat' => $this->faker->latitude, 'lng' => $this->faker->longitude],
            ]), // Generates random waypoints
            'distance' => $this->faker->numberBetween(1, 100), // Random distance between 1 and 100 km
            'elevation_gain' => $this->faker->numberBetween(0, 3000), // Random elevation gain between 0 and 3000 meters
        ];
    }
}
