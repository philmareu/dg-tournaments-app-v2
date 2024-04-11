<?php

namespace Database\Factories;

use App\Models\Tournament;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => fake()->dateTime(),
            'start' => fake()->dateTime(),
            'end' => fake()->dateTime(),
            'summary' => fake()->sentence,
            'location' => fake()->city,
            'tournament_id' => Tournament::factory(),
        ];
    }
}
