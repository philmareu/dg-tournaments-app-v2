<?php

namespace Database\Factories;

use App\Models\Sponsor;
use App\Models\Sponsorship;
use App\Models\Tournament;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TournamentSponsor>
 */
class TournamentSponsorFactory extends Factory
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
            'sponsor_id' => Sponsor::factory(),
            'sponsorship_id' => Sponsorship::factory(),
        ];
    }
}
