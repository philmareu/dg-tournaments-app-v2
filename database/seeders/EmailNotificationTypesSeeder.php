<?php

namespace Database\Seeders;

use App\Models\User\UserEmailNotificationType;
use Illuminate\Database\Seeder;

class EmailNotificationTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserEmailNotificationType::factory()->create([
            'label' => 'PDGA rating updates'
        ]);

        UserEmailNotificationType::factory()->create([
            'label' => 'Important updates from tournaments I follow'
        ]);
    }
}
