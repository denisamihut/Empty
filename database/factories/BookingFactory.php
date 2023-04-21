<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'date' => $this->faker->date(),
            'datefrom' => $this->faker->dateTimeBetween('-10 days', 'now'),
            'dateto' => $this->faker->dateTimeBetween('now', '+30 days'),
            'number' => date('Y') . '-' . str_pad($this->faker->unique()->randomNumber(3), 5, '0', STR_PAD_LEFT),
            'status' => $this->faker->randomElement(['P', 'C', 'A']),
            'amount' => $this->faker->randomFloat(2, 100, 1000),
            'days' => $this->faker->numberBetween(1, 30),
            'notes' => $this->faker->text(),
            'client_id' => $this->faker->numberBetween(1, 50),
            'user_id' => 1,
            'room_id' => $this->faker->numberBetween(1, 50),
            'business_id' => 1,
            'branch_id' => 1,
        ];
    }
}