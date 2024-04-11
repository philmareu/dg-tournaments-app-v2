<?php

namespace Database\Factories;

use App\Models\Upload;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sponsor>
 */
class SponsorFactory extends Factory
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
            'url' => fake()->url(),
            'upload_id' => Upload::factory(),
            'user_id' => User::factory(),
        ];
    }
}
