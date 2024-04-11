<?php

namespace Database\Seeders;

use App\Models\Format;
use Illuminate\Database\Seeder;

class FormatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Format::factory()->create([
            'id' => 1,
            'title' => 'Singles',
            'code' => 'S'
        ]);

        Format::factory()->create([
            'id' => 2,
            'title' => 'Doubles',
            'code' => 'D'
        ]);

        Format::factory()->create([
            'id' => 3,
            'title' => 'University',
            'code' => 'U'
        ]);

        Format::factory()->create([
            'id' => 4,
            'title' => 'Team',
            'code' => 'T'
        ]);

        Format::factory()->create([
            'id' => 5,
            'title' => 'Match Play',
            'code' => 'P'
        ]);
    }
}
