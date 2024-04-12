<?php

namespace Tests\Unit;

use App\Billing\Stripe\StripeBilling;
use App\Models\Order;
use App\Models\Order\OrderSponsorshipProduct;
use App\Models\OrderSponsorship;
use App\Models\Sponsorship;
use App\Models\TournamentOrder;
use App\Models\TournamentOrderSponsorshipProduct;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function should_return_a_new_order_when_one_does_not_exist()
    {
        $order = $this->getRepo()->getOrderOrCreateNew();
        $this->assertDatabaseHas('orders', ['id' => $order->id]);
    }

    /**
     * @test
     */
    public function new_order_is_created_if_unique_is_not_found_in_database()
    {
        $order = $this->getRepo()->getOrderOrCreateNew('thisDoesNotExistInDatabase');

        $this->assertDatabaseHas('orders', ['id' => $order->id]);
    }

    /**
     * @test
     */
    public function should_save_a_sponsorship_product_to_a_tournament_order()
    {
        $sponsorship = Sponsorship::factory()->create();

        $order = $this->getRepo()->addSponsorship($sponsorship);

        $this->assertDatabaseHas('order_sponsorships', [
            'order_id' => $order->id,
            'sponsorship_id' => $sponsorship->id
        ]);
    }

    /**
     * @test
     */
    public function should_return_paid_when_submitting_valid_credentials()
    {
        $orderSponsorship = OrderSponsorship::factory()->create();

        Event::fake();

        $order = $this->getRepo()->pay($orderSponsorship->order, ['source' => 'tok_visa']);

        $this->assertEquals(1, $order->paid);
    }

    private function getRepo()
    {
        return new \App\Repositories\OrderRepository(
            new Order(),
            new StripeBilling()
        );
    }
}
