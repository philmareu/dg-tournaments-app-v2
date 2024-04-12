<?php

namespace Tests\Feature\API\Tournament;

use App\Models\Link;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class LinkValidationTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function storing_a_tournament_link_requires_a_title()
    {
        $this->storing('title');
    }

    #[Test]
    public function storing_a_tournament_link_requires_a_url()
    {
        $this->storing('url');
    }

    #[Test]
    public function storing_a_tournament_link_requires_a_valid_url()
    {
        $this->storing('url', ['url' => 'not a valid url']);
    }

    #[Test]
    public function updating_a_tournament_link_requires_a_title()
    {
        $this->updating('title');
    }

    #[Test]
    public function updating_a_tournament_link_requires_a_url()
    {
        $this->updating('url');
    }

    #[Test]
    public function updating_a_tournament_link_requires_a_valid_url()
    {
        $this->updating('url', ['url' => 'not a valid url']);
    }

    private function storing($key, $data = [])
    {

        [$user, $tournament] = $this->createTournamentWithManager();

        $response = $this->actingAs($user)
            ->json('POST', 'tournament/links/'.$tournament->id, $data);

        $this->assertArrayHasKey($key, $response->getOriginalContent()['errors']);
    }

    private function updating($key, $data = [])
    {

        [$user, $tournament] = $this->createTournamentWithManager();
        $tournament->links()->save(Link::factory()->make());

        $response = $this->actingAs($user)
            ->json('PUT', 'tournament/links/'.$tournament->links->first()->id, $data);

        $this->assertArrayHasKey($key, $response->getOriginalContent()['errors']);
    }
}
