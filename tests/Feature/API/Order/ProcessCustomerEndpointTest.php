<?php

namespace Tests\Feature\API\Order;

use App\Models\OrderSponsorship;
use App\Models\User\User;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class ProcessCustomerEndpointTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Event::fake();
    }

    #[Test]
    public function during_checkout_guest_details_are_saved_on_order()
    {
        $orderProduct = OrderSponsorship::factory()->create();

        $data = [
            'unique' => $orderProduct->order->unique,
            'email' => 'test@test.com',
            'first_name' => 'Test',
            'last_name' => 'Ing'
        ];

        $this->json('PUT', 'order/checkout/details', $data);

        $this->assertDatabaseHas('orders', $data);
    }

    #[Test]
    public function during_checkout_a_guest_can_create_a_new_user_account()
    {
        $orderProduct = OrderSponsorship::factory()->create();

        $data = [
            'unique' => $orderProduct->order->unique,
            'email' => 'test@test.com',
            'first_name' => 'Test',
            'last_name' => 'Ing',
            'password' => 'password',
            'create_account' => 1
        ];

        $this->json('PUT', 'order/checkout/details', $data);

        $this->assertDatabaseHas('users', [
            'email' => 'test@test.com',
            'first_name' => 'Test',
            'last_name' => 'Ing',
            'name' => 'Test Ing'
        ]);
    }

    #[Test]
    public function an_authenticated_user_can_not_create_an_account()
    {
        $orderProduct = OrderSponsorship::factory()->create();

        $data = [
            'unique' => $orderProduct->order->unique,
            'email' => 'test@test.com',
            'first_name' => 'Test',
            'last_name' => 'Ing',
            'password' => 'password',
            'create_account' => 1
        ];

        $this->actingAs(User::factory()->create())
            ->json('PUT', 'order/checkout/details', $data);

        $this->assertDatabaseMissing('users', [
            'email' => 'test@test.com',
            'first_name' => 'Test',
            'last_name' => 'Ing',
            'name' => 'Test Ing'
        ]);
    }

    #[Test]
    public function the_order_is_returned_after_saving_customer_details()
    {
        $orderProduct = OrderSponsorship::factory()->create();

        $data = [
            'unique' => $orderProduct->order->unique,
            'email' => 'test@test.com',
            'first_name' => 'Test',
            'last_name' => 'Ing'
        ];

        $this->json('PUT', 'order/checkout/details', $data)
            ->assertJson([
                'unique' => $orderProduct->order->unique,
                'sponsorships' => []
            ]);
    }

    #[Test]
    public function the_user_is_returned_after_creating_a_new_user_details()
    {
        $orderProduct = OrderSponsorship::factory()->create();

        $data = [
            'unique' => $orderProduct->order->unique,
            'email' => 'test@test.com',
            'first_name' => 'Test',
            'last_name' => 'Ing',
            'password' => 'password',
            'create_account' => 1
        ];

        $this->json('PUT', 'order/checkout/details', $data)
            ->assertJson([
                'unique' => $orderProduct->order->unique,
                'sponsorships' => [],
                'user' => []
            ]);
    }
}
