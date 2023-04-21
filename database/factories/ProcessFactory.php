<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Process>
 */
class ProcessFactory extends Factory
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
            'start_date' => $this->faker->dateTimeBetween('-10 days', 'now'),
            'end_date' => $this->faker->dateTimeBetween('now', '+30 days'),
            'number' => date('Y') . '-' . str_pad($this->faker->unique()->randomNumber(3), 5, '0', STR_PAD_LEFT),
            'status' => $this->faker->randomElement(['P', 'C', 'A']),
            'amount' => $this->faker->randomFloat(2, 100, 1000),
            'days' => $this->faker->numberBetween(1, 30),
            'room_id' => Room::where('status', 'O')->inRandomOrder()->first()->id,
            'client_id' => $this->faker->numberBetween(1, 50),
            'concept_id' => 3,
            'user_id' => 1,
            'business_id' => 1,
            'branch_id' => 1,
            'cashbox_id' => 1,
            'processtype_id' => $this->faker->numberBetween(1, 3),
            'payment_type' => $this->faker->randomElement(['E', 'T']),
            'notes' => $this->faker->text(),
        ];
    }
}