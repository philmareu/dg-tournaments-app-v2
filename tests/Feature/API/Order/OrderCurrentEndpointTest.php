<?php

namespace Tests\Feature\API\Order;

use App\Models\Order;
use App\Models\OrderSponsorshipProduct;
use App\Models\Sponsorship;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderCurrentEndpointTest extends TestCase
{
    use RefreshDatabase;

    protected $endpoint = 'order/current';

    /*
    |--------------------------------------------------------------------------
    | GET
    |--------------------------------------------------------------------------
    */

    /**
     * @test
     */
    public function endpoint_is_available()
    {
        $this->call('GET', $this->endpoint)
            ->assertStatus(200);
    }

    /**
     * @test
     */
    public function should_return_null_if_no_current_order_is_available()
    {
        $response = $this->call('GET', $this->endpoint);

        $this->assertNull($response->getOriginalContent());
    }
}
