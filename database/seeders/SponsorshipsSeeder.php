<?php

namespace Database\Seeders;

use App\Models\Sponsorship;
use App\Models\Tournament;
use Illuminate\Database\Seeder;

class SponsorshipsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect(range(1, 40))->each(function() {
            Sponsorship::factory()->create([
                'tournament_id' => Tournament::inRandomOrder()->first()
            ]);
        });
    }
}
