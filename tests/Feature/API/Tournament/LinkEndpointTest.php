<?php

namespace Tests\Feature\API\Tournament;

use App\Models\Link;
use App\Models\Tournament;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LinkEndpointTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

        Event::fake();
    }

    /** @test */
    public function only_a_manager_can_store_a_link()
    {
        $this->actingAs($this->createUser())
            ->json('POST', 'tournament/links/' . Tournament::factory()->create()->id)
            ->assertStatus(403);
    }

    /** @test */
    public function only_a_manager_can_update_a_link()
    {

        $this->actingAs($this->createUser())
            ->json('PUT', 'tournament/links/' . Link::factory()->create()->id)
            ->assertStatus(403);
    }

    /** @test */
    public function only_a_manager_can_delete_a_link()
    {

        $this->actingAs($this->createUser())
            ->json('DELETE', 'tournament/links/' . Link::factory()->create()->id)
            ->assertStatus(403);
    }

    /** @test */
    public function manager_can_store_a_new_link()
    {
        list($user, $tournament) = $this->createTournamentWithManager();

        $data = [
            'title' => 'Link Title',
            'url' => 'http://testing.com',
            'ordinal' => 1
        ];

        $this->actingAs($user)
            ->json('POST', 'tournament/links/' . $tournament->id, $data)
            ->assertJson([
                [
                    'title' => 'Link Title',
                    'url' => 'http://testing.com',
                    'ordinal' => 1
                ]
            ]);

        $link = $tournament->links->first();

        $this->assertEquals($data['title'], $link->title);
        $this->assertEquals($data['url'], $link->url);
        $this->assertEquals($data['ordinal'], $link->ordinal);
    }

    /** @test */
    public function manager_can_update_a_link()
    {
        list($user, $tournament) = $this->createTournamentWithManager();

        $tournament->links()->save(Link::factory()->make());

        $data = [
            'title' => 'Link Title',
            'url' => 'http://testing.com',
            'ordinal' => 1
        ];

        $this->actingAs($user)
            ->json('PUT', 'tournament/links/' . $tournament->links->first()->id, $data)
            ->assertJson([
                [
                    'title' => 'Link Title',
                    'url' => 'http://testing.com',
                    'ordinal' => 1
                ]
            ]);

        $link = $tournament->fresh()->links->first();

        $this->assertEquals($data['title'], $link->title);
        $this->assertEquals($data['url'], $link->url);
        $this->assertEquals($data['ordinal'], $link->ordinal);
    }

    /** @test */
    public function manager_can_delete_a_link()
    {
        list($user, $tournament) = $this->createTournamentWithManager();

        $tournament->links()->save(Link::factory()->make());

        $this->actingAs($user)
            ->json('DELETE', 'tournament/links/' . $tournament->links->first()->id)
            ->assertJson([]);

        $this->assertEquals(0, $tournament->fresh()->links->count());
    }
}
