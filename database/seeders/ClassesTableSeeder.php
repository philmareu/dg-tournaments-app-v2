<?php

namespace Database\Seeders;

use App\Models\Classes;
use Illuminate\Database\Seeder;

class ClassesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Classes::factory()->create([
            'title' => 'Pro'
        ]);

        Classes::factory()->create([
            'title' => 'Am'
        ]);
    }
}
