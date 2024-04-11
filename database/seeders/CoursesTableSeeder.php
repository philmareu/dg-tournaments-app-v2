<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Tournament;
use Illuminate\Database\Seeder;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tournaments = Tournament::all();

        $tournaments->each(function(Tournament $tournament) {
            Course::factory()->count(3)->create([
                'latitude' => $tournament->latitude + (rand(0, 10) / 10),
                'longitude' => $tournament->longitude + (rand(0, 10) / 10)
            ]);
        });
    }
}
