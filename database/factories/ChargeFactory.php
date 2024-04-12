<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Charge>
 */
class ChargeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'charge_id' => fake()->word(),
            'status' => fake()->word(),
            'amount' => fake()->numberBetween(100, 1000),
            'order_id' => Order::factory(),
        ];
    }

    public function successful()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'succeeded',
            ];
        });
    }
}
