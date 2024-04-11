<?php

namespace Database\Seeders;

use App\Models\PdgaTier;
use Illuminate\Database\Seeder;

class PdgaTierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PdgaTier::factory()->create([
            'id' => 1,
            'title' => 'Major',
            'code' => 'M'
        ]);

        PdgaTier::factory()->create([
            'id' => 2,
            'title' => 'National Tour',
            'code' => 'NT'
        ]);

        PdgaTier::factory()->create([
            'id' => 3,
            'title' => 'A',
            'code' => 'A'
        ]);

        PdgaTier::factory()->create([
            'id' => 4,
            'title' => 'B',
            'code' => 'B'
        ]);

        PdgaTier::factory()->create([
            'id' => 5,
            'title' => 'C',
            'code' => 'C'
        ]);
    }
}
