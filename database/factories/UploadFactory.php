<?php

namespace Database\Factories;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Upload>
 */
class UploadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'filename' => fake()->word(),
            'title' => fake()->word(),
            'alt' => fake()->word(),
            'mime' => fake()->mimeType(),
            'size' => fake()->randomNumber(5),
            'user_id' => User::factory(),
        ];
    }
}
