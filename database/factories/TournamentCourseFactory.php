<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Tournament;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TournamentCourse>
 */
class TournamentCourseFactory extends Factory
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
            'address' => fake()->streetAddress(),
            'address_2' => fake()->streetAddress(),
            'city' => fake()->city(),
            'state_province' => fake()->word(),
            'country' => fake()->country(),
            'notes' => fake()->paragraph(),
            'directions' => fake()->paragraph(),
            'latitude' => fake()->latitude(),
            'longitude' => fake()->longitude(),
            'holes' => fake()->randomElement([9, 18, 27]),
            'course_id' => Course::factory(),
            'tournament_id' => Tournament::factory(),
        ];
    }
}
