<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Registration;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderRegistration>
 */
class OrderRegistrationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'registration_id' => Registration::factory(),
            'cost' => fake()->randomNumber(4),
        ];
    }
}
