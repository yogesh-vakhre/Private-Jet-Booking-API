<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FlightFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'from' => $this->faker->city,
            'to' => $this->faker->city,
            'departure_time' => $this->faker->dateTimeBetween('+1 days', '+5 days'),
            'arrival_time' => $this->faker->dateTimeBetween('+6 days', '+10 days'),
            'price' => $this->faker->randomFloat(2, 5000, 25000),
        ];
    }
}
