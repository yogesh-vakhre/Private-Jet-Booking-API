<?php

namespace Database\Factories;

use App\Models\Flight;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $userIds = User::pluck('id')->all(); // Get all user IDs
        $flightIds = Flight::pluck('id')->all(); // Get all flight_id IDs
        return [
            'user_id' => $this->faker->randomElement($userIds),
            'flight_id' => $this->faker->randomElement($flightIds),
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'cancelled']),
        ];
    }
}
