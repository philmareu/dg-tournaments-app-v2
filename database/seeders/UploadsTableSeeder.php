<?php

namespace Database\Seeders;

use App\Models\Upload;
use Illuminate\Database\Seeder;

class UploadsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Upload::factory()->create([
            'filename' => '2scd7Ugf0VqaPrrhIGR0Cvph5otY0g0L938ykVV5.jpeg'
        ]);

        Upload::factory()->create([
            'filename' => 'lPitFqzgDlTgS5QKkLgH1GPfzK4pSBPG4TFoMelY.jpeg'
        ]);
    }
}
