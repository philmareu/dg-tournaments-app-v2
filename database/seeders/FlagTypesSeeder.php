<?php

namespace Database\Seeders;

namespace Database\Seeders;

use App\Models\FlagType;
use Illuminate\Database\Seeder;

class FlagTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FlagType::factory()->create([
            'id' => 1,
            'title' => 'Needs Lat/Lng',
        ]);

        FlagType::factory()->create([
            'id' => 2,
            'title' => 'Needs Course',
        ]);

        FlagType::factory()->create([
            'id' => 3,
            'title' => 'Needs Registration Link',
        ]);

        FlagType::factory()->create([
            'id' => 4,
            'title' => 'Potential Women\'s only event',
        ]);

        FlagType::factory()->create([
            'id' => 5,
            'title' => 'Potential Junior\'s only event',
        ]);
    }
}
