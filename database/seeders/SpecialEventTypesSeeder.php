<?php

namespace Database\Seeders;

use App\Models\SpecialEventType;
use Illuminate\Database\Seeder;

class SpecialEventTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SpecialEventType::factory()->create([
            'id' => 1,
            'title' => 'Women\'s Only',
            'slug' => 'women-only',
        ]);

        SpecialEventType::factory()->create([
            'id' => 2,
            'title' => 'Charity/Fundraiser',
            'slug' => 'charity',
        ]);

        SpecialEventType::factory()->create([
            'id' => 3,
            'title' => 'Junior\'s Only',
            'slug' => 'junior-only',
        ]);
    }
}
