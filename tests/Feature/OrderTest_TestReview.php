<?php

namespace Tests\Feature;

use App\Billing\Stripe\StripeBilling;
use App\Events\OrderPaid;
use App\Mail\Managers\NewOrderPaidMailable;
use App\Mail\User\OrderConfirmationMailable;
use App\Models\Order;
use App\Models\OrderSponsorship;
use App\Models\Sponsorship;
use App\Models\Tournament;
use App\Models\StripeAccount;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest_TestReview extends TestCase
{
    use RefreshDatabase;


    public function charge_is_created_when_payment_is_submitted()
    {
        $orderSponsorship = OrderSponsorship::factory()->create();

        $response = $this->json('POST', 'order/checkout/pay', ['source' => 'tok_visa', 'unique' => $orderSponsorship->order->unique]);

        $this->assertDatabaseHas('charges', [
            'order_id' => $orderSponsorship->order->id,
            'status' => 'succeeded',
            'amount' => $orderSponsorship->order->total->inCents()
        ]);
    }


    public function order_paid_event_is_fired()
    {
        $orderSponsorship = OrderSponsorship::factory()->create();

        Event::fake();

        $this->json('POST', 'order/checkout/pay', ['source' => 'tok_visa', 'unique' => $orderSponsorship->order->unique]);

        Event::assertDispatched(OrderPaid::class, function ($event) use ($orderSponsorship) {
            return $event->order->id === $orderSponsorship->order->id;
        });
    }


    public function confirmation_email_is_sent_after_order_is_paid()
    {
        $orderSponsorship = OrderSponsorship::factory()->create();

        Mail::fake();

        $this->json('POST', 'order/checkout/pay', ['source' => 'tok_visa', 'unique' => $orderSponsorship->order->unique]);

        Mail::assertQueued(OrderConfirmationMailable::class, function ($mail) use ($orderSponsorship) {
            return $mail->order->id === $orderSponsorship->order->id
                && $mail->hasTo($orderSponsorship->order->email);
        });
    }


    public function tournament_managers_receive_email_about_order_with_sponsorships()
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

        Mail::fake();

        $this->json('POST', 'order/checkout/pay', ['source' => 'tok_visa', 'unique' => $order->unique]);

        Mail::assertQueued(NewOrderPaidMailable::class, function ($mail) use ($tournament1, $order) {
            return $mail->hasTo($tournament1->authorization_email)
                && empty(
                    array_diff($mail->orderSponsorships->pluck('id')->toArray(),
                        $order->sponsorships->whereIn('sponsorship_id', $tournament1->sponsorships->pluck('id'))->pluck('id')->toArray())
                );
        });

        Mail::assertQueued(NewOrderPaidMailable::class, function ($mail) use ($tournament2, $order) {
            return $mail->hasTo($tournament2->authorization_email)
                && empty(
                array_diff($mail->orderSponsorships->pluck('id')->toArray(),
                    $order->sponsorships->whereIn('sponsorship_id', $tournament2->sponsorships->pluck('id'))->pluck('id')->toArray())
                );
        });
    }


    public function order_total_is_sum_of_all_sponsorships()
    {
        $order = Order::factory()->create();

        // Tournament #1
        $tournament1 = Tournament::factory()->create();
        $tournament1Sponsorships = $tournament1->sponsorships()->saveMany(Sponsorship::factory()->count(3)->make());
        $tournament1Sponsorships->each(function (Sponsorship $sponsorship) use ($order) {
            $this->addSponsorshipToOrder($order, $sponsorship);
        });

        $total1 = $tournament1->sponsorships->reduce(function($carry, Sponsorship $sponsorship) {
            return $carry + $sponsorship->cost->inCents();
        });

        // Tournament #2
        $tournament2 = Tournament::factory()->create();
        $tournament2Sponsorships = $tournament2->sponsorships()->saveMany(Sponsorship::factory()->count(2)->make());
        $tournament2Sponsorships->each(function (Sponsorship $sponsorship) use ($order) {
            $this->addSponsorshipToOrder($order, $sponsorship);
        });

        $total2 = $tournament2->sponsorships->reduce(function($carry, Sponsorship $sponsorship) {
            return $carry + $sponsorship->cost->inCents();
        });

        $this->assertEquals($total1 + $total2, $order->total->inCents());
    }


    public function order_payment_transfers_are_saved_to_database()
    {
        $order = Order::factory()->create();

        // Tournament #1
        $tournament1 = $this->createTournament();
        $stripeAccount = StripeAccount::factory()->create([
            'access_token' => env('STRIPE_TEST_ACCOUNT_1_SECRET'),
            'stripe_user_id' => env('STRIPE_TEST_ACCOUNT_1_ACCOUNT')
        ]);
        $tournament1->stripeAccount()->associate($stripeAccount)->save();
        $tournament1Sponsorships = $tournament1->sponsorships()->saveMany(Sponsorship::factory()->count(3)->make());
        $tournament1Sponsorships->each(function (Sponsorship $sponsorship) use ($order) {
            $this->addSponsorshipToOrder($order, $sponsorship);
        });

        $total1 = $tournament1->sponsorships->reduce(function($carry, Sponsorship $sponsorship) {
            return $carry + $sponsorship->cost->inCents();
        });

        // Tournament #2
        $tournament2 = Tournament::factory()->create();
        $stripeAccount = StripeAccount::factory()->create([
            'access_token' => env('STRIPE_TEST_ACCOUNT_2_SECRET'),
            'stripe_user_id' => env('STRIPE_TEST_ACCOUNT_2_ACCOUNT')
        ]);
        $tournament2->stripeAccount()->associate($stripeAccount)->save();
        $tournament2Sponsorships = $tournament2->sponsorships()->saveMany(Sponsorship::factory()->count(2)->make());
        $tournament2Sponsorships->each(function (Sponsorship $sponsorship) use ($order) {
            $this->addSponsorshipToOrder($order, $sponsorship);
        });

        $total2 = $tournament2->sponsorships->reduce(function($carry, Sponsorship $sponsorship) {
            return $carry + $sponsorship->cost->inCents();
        });

        $this->json('POST', 'order/checkout/pay', ['source' => 'tok_visa', 'unique' => $order->unique]);

        $this->assertDatabaseHas('transfers', [
            'order_id' => $order->id,
            'amount' => $total1 - ($total1 * .029 + 30),
            'destination' => $tournament1->stripeAccount->stripe_user_id
        ]);

        $this->assertDatabaseHas('transfers', [
            'order_id' => $order->id,
            'amount' => $total2 - ($total2 * .029 + 30),
            'destination' => $tournament2->stripeAccount->stripe_user_id
        ]);
    }


    public function transfer_are_made_to_tournament_stripe_accounts()
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

        $this->json('POST', 'order/checkout/pay', ['source' => 'tok_visa', 'unique' => $order->unique]);

        // Check for transfers
    }

    private function addSponsorshipToOrder(Order $order, Sponsorship $sponsorship)
    {
        $orderSponsorship = new OrderSponsorship(['cost' => $sponsorship->cost->inDollars()]);
        $orderSponsorship->sponsorship()->associate($sponsorship);
        $orderSponsorship->order()->associate($order);

        $orderSponsorship->save();
    }
}
