<?php

namespace Tests\Feature\API\Tournament;

use App\Models\Sponsor;
use App\Models\Sponsorship;
use App\Models\TournamentSponsor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SponsorEndpointTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Event::fake();
    }

    #[Test]
    public function only_a_manager_can_store_a_tournament_sponsor()
    {

        $this->actingAs($this->createUser())
            ->json('POST', 'tournament/sponsorship/sponsors/'.Sponsorship::factory()->create()->id)
            ->assertStatus(403);
    }

    #[Test]
    public function only_a_manager_can_update_a_tournament_sponsor()
    {

        $this->actingAs($this->createUser())
            ->json('PUT', 'tournament/sponsorship/sponsors/'.TournamentSponsor::factory()->create()->id)
            ->assertStatus(403);
    }

    #[Test]
    public function only_a_manager_can_delete_a_tournament_sponsor()
    {

        $this->actingAs($this->createUser())
            ->json('DELETE', 'tournament/sponsorship/sponsors/'.TournamentSponsor::factory()->create()->id)
            ->assertStatus(403);
    }

    #[Test]
    public function manager_can_store_a_new_tournament_sponsor()
    {
        [$user, $tournament] = $this->createTournamentWithManager();

        $sponsor = Sponsor::factory()->create();
        $sponsorship = Sponsorship::factory()->create();
        $product = $tournament->sponsorships()->save($sponsorship);

        $data = [
            'sponsor_id' => $sponsor->id,
        ];

        $this->actingAs($user)
            ->json('POST', 'tournament/sponsorship/sponsors/'.$sponsorship->id, $data)
            ->assertJson([
                [
                    'sponsor_id' => $sponsor->id,
                    'sponsorship_id' => $sponsorship->id,
                    'tournament_id' => $tournament->id,
                ],
            ]);

        $this->assertDatabaseHas('tournament_sponsors', [
            'sponsor_id' => $sponsor->id,
            'sponsorship_id' => $sponsorship->id,
            'tournament_id' => $tournament->id,
        ]);
    }

    #[Test]
    public function manager_has_ability_to_update_a_tournament_sponsor()
    {
        [$user, $tournament] = $this->createTournamentWithManager();

        $tournamentSponsor = TournamentSponsor::factory()->create();
        $tournament->sponsors()->save($tournamentSponsor);

        $newSponsor = Sponsor::factory()->create();

        $data = [
            'sponsor_id' => $newSponsor->id,
        ];

        $this->actingAs($user)
            ->json('PUT', 'tournament/sponsorship/sponsors/'.$tournamentSponsor->id, $data)
            ->assertJson([
                [
                    'sponsor_id' => $newSponsor->id,
                    'sponsorship_id' => $tournamentSponsor->sponsorship_id,
                    'tournament_id' => $tournament->id,
                ],
            ]);
    }

    #[Test]
    public function manager_can_delete_a_tournament_sponsor()
    {
        [$user, $tournament] = $this->createTournamentWithManager();

        $tournamentSponsor = TournamentSponsor::factory()->create();

        $this->actingAs($user)
            ->json('DELETE', 'tournament/sponsorship/sponsors/'.$tournamentSponsor->id)
            ->assertJson([]);

        $this->assertEquals(0, $tournament->load('sponsors')->sponsors->count());
    }
}
