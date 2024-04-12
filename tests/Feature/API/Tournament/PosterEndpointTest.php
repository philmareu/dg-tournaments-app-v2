<?php

namespace Tests\Feature\API\Tournament;

use App\Models\Tournament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PosterEndpointTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Event::fake();
    }

    #[Test]
    public function guests_cannot_delete_tournament_poster()
    {

        $this->json('DELETE', 'tournament/poster/'.Tournament::factory()->create()->id)
            ->assertStatus(401);
    }

    #[Test]
    public function only_a_manager_can_delete_tournament_poster()
    {

        $this->actingAs($this->createUser())
            ->json('DELETE', 'tournament/poster/'.Tournament::factory()->create()->id)
            ->assertStatus(403);
    }

    #[Test]
    public function manager_can_delete_tournament_poster()
    {
        [$user, $tournament] = $this->createTournamentWithManager();

        $this->actingAs($user)
            ->json('DELETE', 'tournament/poster/'.$tournament->id)
            ->assertJson([
                'id' => null,
            ]);

        $this->assertNull($tournament->poster->id);
    }
}
