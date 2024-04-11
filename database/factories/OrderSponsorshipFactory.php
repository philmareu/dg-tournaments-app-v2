<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Sponsorship;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderSponsorship>
 */
class OrderSponsorshipFactory extends Factory
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
            'sponsorship_id' => Sponsorship::factory(),
            'cost' => fake()->randomNumber(3)
        ];
    }
}
