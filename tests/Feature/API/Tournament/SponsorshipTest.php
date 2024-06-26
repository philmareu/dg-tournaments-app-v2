<?php

namespace Tests\Feature\API\Tournament;

use App\Data\Price;
use App\Models\Sponsorship;
use App\Models\Tournament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SponsorshipTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Event::fake();
    }

    #[Test]
    public function only_a_manager_can_store_a_sponsorship_product()
    {

        $this->actingAs($this->createUser())
            ->json('POST', 'tournament/sponsorships/'.Tournament::factory()->create()->id)
            ->assertStatus(403);
    }

    #[Test]
    public function only_a_manager_can_update_a_sponsorship_product()
    {

        $this->actingAs($this->createUser())
            ->json('PUT', 'tournament/sponsorships/'.Sponsorship::factory()->create()->id)
            ->assertStatus(403);
    }

    #[Test]
    public function only_a_manager_can_delete_a_sponsorship_product()
    {

        $this->actingAs($this->createUser())
            ->json('DELETE', 'tournament/sponsorships/'.Sponsorship::factory()->create()->id)
            ->assertStatus(403);
    }

    #[Test]
    public function manager_can_store_a_new_sponsorship_product()
    {
        [$user, $tournament] = $this->createTournamentWithManager();

        $data = [
            'title' => 'Sponsorship Product Title',
            'tier' => 1,
            'quantity' => 10,
            'cost_in_dollars' => 100,
            'description' => 'This is the test description',
        ];

        $this->actingAs($user)
            ->json('POST', 'tournament/sponsorships/'.$tournament->id, $data);

        $sponsorship = $tournament->sponsorships->first();

        $this->assertEquals($data['title'], $sponsorship->title);
        $this->assertEquals($data['tier'], $sponsorship->tier);
        $this->assertEquals($data['quantity'], $sponsorship->quantity);
        $this->assertInstanceOf(Price::class, $sponsorship->cost);
        $this->assertEquals($data['description'], $sponsorship->description);
    }

    #[Test]
    public function manager_can_update_a_sponsorship_product()
    {
        [$user, $tournament] = $this->createTournamentWithManager();

        $tournament->sponsorships()->save(Sponsorship::factory()->make());

        $data = [
            'title' => 'Sponsorship Product Title',
            'tier' => 1,
            'quantity' => 10,
            'cost_in_dollars' => 100,
            'description' => 'This is the test description',
        ];

        $this->actingAs($user)
            ->json('PUT', 'tournament/sponsorships/'.$tournament->sponsorships->first()->id, $data);

        $sponsorship = $tournament->fresh()->sponsorships->first();

        $this->assertEquals($data['title'], $sponsorship->title);
        $this->assertEquals($data['tier'], $sponsorship->tier);
        $this->assertEquals($data['quantity'], $sponsorship->quantity);
        $this->assertInstanceOf(Price::class, $sponsorship->cost);
        $this->assertEquals($data['description'], $sponsorship->description);
    }

    #[Test]
    public function manager_can_delete_a_sponsorship_product()
    {
        [$user, $tournament] = $this->createTournamentWithManager();

        $tournament->sponsorships()->save(Sponsorship::factory()->make());

        $data = [
            'title' => 'SponsorshipProduct Title',
            'url' => 'http://testing.com',
            'ordinal' => 10,
        ];

        $this->actingAs($user)
            ->json('DELETE', 'tournament/sponsorships/'.$tournament->sponsorships->first()->id, $data);

        $this->assertEquals(0, $tournament->load('sponsorships')->sponsorships->count());
    }
}
