<?php

namespace Tests\Unit\Collections;

use App\Models\Order;
use App\Models\OrderSponsorship;
use App\Models\Sponsorship;
use App\Models\Tournament;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderSponsorshipsCollectionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function should_return_a_collection_of_order_sponsorships_grouped_by_tournament_id()
    {
        $order = Order::factory()->create();

        // Tournament #1
        $tournament1 = Tournament::factory()->create();
        $tournament1Sponsorships = $tournament1->sponsorships()->saveMany(Sponsorship::factory()->count(3)->make());
        $tournament1Sponsorships->each(function (Sponsorship $sponsorship) use ($order) {
            $this->addSponsorshipToOrder($order, $sponsorship);
        });

        // Tournament #2
        $tournament2 = Tournament::factory()->create();
        $tournament2Sponsorships = $tournament2->sponsorships()->saveMany(Sponsorship::factory()->count(2)->make());
        $tournament2Sponsorships->each(function (Sponsorship $sponsorship) use ($order) {
            $this->addSponsorshipToOrder($order, $sponsorship);
        });

        $this->assertEquals([$tournament1->id, $tournament2->id], $order->sponsorships->sortSponsorshipsByTournament()->keys()->toArray());
    }

    private function addSponsorshipToOrder(Order $order, Sponsorship $sponsorship)
    {
        $orderSponsorship = new OrderSponsorship(['cost' => $sponsorship->cost->inDollars()]);
        $orderSponsorship->sponsorship()->associate($sponsorship);
        $orderSponsorship->order()->associate($order);

        $orderSponsorship->save();
    }
}
