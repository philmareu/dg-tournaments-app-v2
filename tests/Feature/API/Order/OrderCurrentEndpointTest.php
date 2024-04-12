<?php

namespace Tests\Feature\API\Order;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class OrderCurrentEndpointTest extends TestCase
{
    use RefreshDatabase;

    protected $endpoint = 'order/current';

    /*
    |--------------------------------------------------------------------------
    | GET
    |--------------------------------------------------------------------------
    */

    #[Test]
    public function endpoint_is_available()
    {
        $this->call('GET', $this->endpoint)
            ->assertStatus(200);
    }

    #[Test]
    public function should_return_null_if_no_current_order_is_available()
    {
        $response = $this->call('GET', $this->endpoint);

        $this->assertNull($response->getOriginalContent());
    }
}
