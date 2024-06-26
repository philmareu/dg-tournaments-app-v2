<?php

namespace Tests\Feature\API\Order;

use App\Models\Order;
use App\Models\OrderSponsorship;
use App\Models\Sponsorship;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SponsorshipProductsEndpointTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Event::fake();
    }

    #[Test]
    public function order_cookie_is_returned_with_adding_sponsorship_to_order()
    {
        $sponsorship = Sponsorship::factory()->create();

        $this->json('PUT', 'order/sponsorships/'.$sponsorship->id)
            ->assertCookie('_oo');
    }

    #[Test]
    public function sponsorship_product_can_be_added_to_order()
    {
        $sponsorship = Sponsorship::factory()->create();

        $response = $this->json('PUT', 'order/sponsorships/'.$sponsorship->id);

        $this->assertDatabaseHas('order_sponsorships', [
            'order_id' => $response->getOriginalContent()->id,
            'sponsorship_id' => $sponsorship->id,
            'cost' => $sponsorship->cost->inCents(),
        ]);
    }

    #[Test]
    public function sponsorship_product_can_be_deleted_from_order()
    {
        $orderSponsorship = OrderSponsorship::factory()->create();

        $this->json('DELETE', 'order/sponsorships/'.$orderSponsorship->id)
            ->assertStatus(200);

        $this->assertDatabaseMissing('order_sponsorships', [
            'id' => $orderSponsorship->id,
        ]);
    }

    #[Test]
    public function sponsorships_can_not_be_deleted_from_paid_orders()
    {
        $orderSponsorship = OrderSponsorship::factory()->create();
        $order = $orderSponsorship->order;
        $order->paid = 1;
        $order->save();

        $this->json('DELETE', 'order/sponsorships/'.$orderSponsorship->id)
            ->assertStatus(200);

        // Assert that it does still exist

        $this->assertDatabaseHas('order_sponsorships', [
            'id' => $orderSponsorship->id,
            'order_id' => $order->id,
        ]);
    }

    #[Test]
    public function data_is_loaded_when_adding_sponsorships()
    {
        $sponsorship = Sponsorship::factory()->create();

        $this->json('PUT', 'order/sponsorships/'.$sponsorship->id)
            ->assertJson([
                'sponsorships' => [
                    [
                        'id' => $sponsorship->id,
                        'sponsorship' => [
                            'tournament' => [
                                'poster' => [],
                            ],
                        ],
                        'cost' => $sponsorship->cost->inCents(),
                    ],
                ],
            ]);
    }

    #[Test]
    public function data_is_loaded_when_removing_sponsorships()
    {
        $order = Order::factory()->create();

        OrderSponsorship::factory()->count(2)->create([
            'order_id' => $order->id,
        ]);

        $this->json('DELETE', 'order/sponsorships/1')
            ->assertJson([
                'sponsorships' => [
                    [
                        'id' => 2,
                        'sponsorship' => [
                            'tournament' => [
                                'poster' => [],
                            ],
                        ],
                    ],
                ],
            ]);
    }
}
