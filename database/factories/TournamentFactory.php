<?php

namespace Database\Factories;

use App\Models\Format;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tournament>
 */
class TournamentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = Carbon::now()->addDays(rand(1, 60));

        return [
            'name' => fake()->word(),
            'slug' => fake()->word(),
            'city' => fake()->city,
            'state_province' => 'Kansas',
            'country' => fake()->country(),
            'start' => $date,
            'end' => $date->addDay(),
            'authorization_email' => fake()->email(),
            'director' => fake()->name(),
            'phone' => fake()->phoneNumber(),
            'latitude' => fake()->randomFloat(6, 30, 49),
            'longitude' => fake()->randomFloat(6, -124, -74),
            'description' => fake()->sentence(),
            'poster_id' => null,
            'format_id' => Format::factory(),
        ];
    }

    public function noGeo()
    {
        return $this->state(function (array $attribute) {
            return [
                'latitude' => null,
                'longitude' => null,
            ];
        });
    }

    public function future()
    {
        $date = Carbon::now()->addDays(rand(1, 60));

        return $this->state(function (array $attribute) use ($date) {
            return [
                'start' => $date,
                'end' => $date->addDay()
            ];
        });
    }
}
