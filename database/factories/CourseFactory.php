<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'slug' => fake()->word(),
            'address' => fake()->streetAddress,
            'address_2' => fake()->streetAddress,
            'city' => fake()->city,
            'state_province' => fake()->word(),
            'country' => fake()->country,
            'description' => fake()->paragraph,
            'directions' => fake()->paragraph,
            'length' => fake()->randomNumber(4),
            'latitude' => fake()->latitude,
            'longitude' => fake()->longitude
        ];
    }
}
