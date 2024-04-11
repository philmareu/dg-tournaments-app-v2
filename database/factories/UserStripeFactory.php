<?php

namespace Database\Factories;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserStripe>
 */
class UserStripeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'display_name' => fake()->word(),
            'access_token' => fake()->word(),
            'stripe_user_id' => fake()->word(),
            'user_id' => User::factory(),
        ];
    }
}
