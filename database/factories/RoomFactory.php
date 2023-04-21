<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => 'Habitación - ' . $this->faker->unique()->randomNumber(3),
            'status' => 'D',
            'room_type_id' => $this->faker->numberBetween(1, 3),
            'floor_id' => $this->faker->numberBetween(1, 3),
            'branch_id' => 1,
            'business_id' => 1,
        ];
    }
}