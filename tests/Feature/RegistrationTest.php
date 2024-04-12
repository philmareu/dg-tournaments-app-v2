<?php

namespace Tests\Feature;

use App\Models\Tournament;
use App\Models\User\User;
use Illuminate\Auth\Events\Registered;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed('EmailNotificationTypesSeeder');
    }

    /**
     * @test
     */
    public function user_becomes_manager_of_any_tournaments_with_an_authorization_email_that_matches_their_email()
    {
        $user = User::factory()->create([
            'email' => 'email@email.com'
        ]);

        $tournament1 = Tournament::factory()->create([
            'authorization_email' => $user->email
        ]);

        $tournament2 = Tournament::factory()->create([
            'authorization_email' => $user->email
        ]);

        $tournament3 = Tournament::factory()->create([
            'authorization_email' => 'no@no.com'
        ]);

        event(new Registered($user));

        $this->assertDatabaseHas('managers', [
            'user_id' => $user->id,
            'tournament_id' => $tournament1->id
        ]);

        $this->assertDatabaseHas('managers', [
            'user_id' => $user->id,
            'tournament_id' => $tournament2->id
        ]);

        $this->assertDatabaseMissing('managers', [
            'user_id' => $user->id,
            'tournament_id' => $tournament3->id
        ]);
    }
}
