<?php

namespace Tests\Unit;

use App\Billing\Stripe\StripeBilling;
use App\Models\Order;
use App\Models\OrderSponsorship;
use App\Models\Sponsorship;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class OrderRepositoryTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function should_return_a_new_order_when_one_does_not_exist()
    {
        $order = $this->getRepo()->getOrderOrCreateNew();
        $this->assertDatabaseHas('orders', ['id' => $order->id]);
    }

    #[Test]
    public function new_order_is_created_if_unique_is_not_found_in_database()
    {
        $order = $this->getRepo()->getOrderOrCreateNew('thisDoesNotExistInDatabase');

        $this->assertDatabaseHas('orders', ['id' => $order->id]);
    }

    #[Test]
    public function should_save_a_sponsorship_product_to_a_tournament_order()
    {
        $sponsorship = Sponsorship::factory()->create();

        $order = $this->getRepo()->addSponsorship($sponsorship);

        $this->assertDatabaseHas('order_sponsorships', [
            'order_id' => $order->id,
            'sponsorship_id' => $sponsorship->id,
        ]);
    }

    #[Test]
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
