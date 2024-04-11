<?php

namespace Database\Factories;

use App\Models\Tournament;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sponsorship>
 */
class SponsorshipFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->word(),
            'tier' => fake()->numberBetween(1, 5),
            'quantity' => fake()->randomNumber(1),
            'cost' => fake()->numberBetween(10, 100),
            'description' => fake()->paragraph(),
            'tournament_id' => Tournament::factory(),
        ];
    }
}
