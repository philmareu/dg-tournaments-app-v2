<?php

namespace Tests\Feature\API\Tournament;

use App\Models\Sponsorship;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SponsorshipValidationTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function storing_a_sponsorship_product_requires_a_title()
    {
        $this->storing('title');
    }

    #[Test]
    public function storing_a_sponsorship_product_requires_a_tier()
    {
        $this->storing('tier');
    }

    #[Test]
    public function storing_a_sponsorship_product_requires_a_tier_to_be_an_integer()
    {
        $this->storing('tier', ['tier' => 'Not an integer']);
    }

    #[Test]
    public function storing_a_sponsorship_product_requires_a_tier_to_be_less_than_100()
    {
        $this->storing('tier', ['tier' => 200]);
    }

    #[Test]
    public function storing_a_sponsorship_product_requires_a_quantity()
    {
        $this->storing('quantity');
    }

    #[Test]
    public function storing_a_sponsorship_product_requires_a_quantity_to_be_an_integer()
    {
        $this->storing('quantity', ['quantity' => 'Not an integer']);
    }

    #[Test]
    public function storing_a_sponsorship_product_requires_a_cost_in_dollars()
    {
        $this->storing('cost_in_dollars');
    }

    #[Test]
    public function storing_a_sponsorship_product_requires_a_cost_in_dollars_to_be_numeric()
    {
        $this->storing('cost_in_dollars', ['cost_in_dollars' => 'Not numeric']);
    }

    #[Test]
    public function updating_a_sponsorship_product_requires_a_tier_to_be_an_integer()
    {
        $this->updating('tier', ['tier' => 'Not an integer']);
    }

    #[Test]
    public function updating_a_sponsorship_product_requires_a_tier_to_be_less_than_100()
    {
        $this->updating('tier', ['tier' => 200]);
    }

    #[Test]
    public function updating_a_sponsorship_product_requires_a_quantity_to_be_an_integer()
    {
        $this->updating('quantity', ['quantity' => 'Not an integer']);
    }

    #[Test]
    public function updating_a_sponsorship_product_requires_a_cost_in_dollars_to_be_numeric()
    {
        $this->updating('cost_in_dollars', ['cost_in_dollars' => 'Not numeric']);
    }

    private function storing($key, $data = [])
    {

        [$user, $tournament] = $this->createTournamentWithManager();

        $response = $this->actingAs($user)
            ->json('POST', 'tournament/sponsorships/'.$tournament->id, $data);

        $this->assertArrayHasKey($key, $response->getOriginalContent()['errors']);
    }

    private function updating($key, $data = [])
    {

        [$user, $tournament] = $this->createTournamentWithManager();
        $tournament->sponsorships()->save(Sponsorship::factory()->make());

        $response = $this->actingAs($user)
            ->json('PUT', 'tournament/sponsorships/'.$tournament->sponsorships->first()->id, $data);

        $this->assertArrayHasKey($key, $response->getOriginalContent()['errors']);
    }
}
