<?php

namespace Database\Factories;

use App\Models\Tournament;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Registration>
 */
class RegistrationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tournament_id' => Tournament::factory(),
            'opens_at' => Carbon::now()->subDay(),
            'closes_at' => Carbon::now()->addMonth(),
            'url' => fake()->url,
        ];
    }
}
