<?php

namespace Tests\Feature\API\Order;

use App\Models\Order;
use App\Models\Order\OrderSponsorshipProduct;
use App\Models\OrderSponsorship;
use App\Models\Sponsorship;
use App\Models\StripeAccount;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PayOrderEndpointTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function order_returned_as_paid_when_charge_is_successful()
    {
        Event::fake();

        $tournament1 = $this->createTournament();
        $stripeAccount = StripeAccount::factory()->create([
            'access_token' => env('STRIPE_TEST_ACCOUNT_1_SECRET'),
            'stripe_user_id' => env('STRIPE_TEST_ACCOUNT_1_ACCOUNT')
        ]);
        $tournament1->stripeAccount()->associate($stripeAccount)->save();
        $sponsorship = Sponsorship::factory()->create([
            'tournament_id' => $tournament1->id
        ]);
        $orderSponsorship = OrderSponsorship::factory()->create([
            'sponsorship_id' => $sponsorship->id
        ]);

        $this->json('POST', 'order/checkout/pay', ['source' => ['source' => 'tok_visa'], 'unique' => $orderSponsorship->order->unique])
            ->assertJson([
                'paid' => 1
            ]);
    }
}
