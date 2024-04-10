<?php

namespace App\Billing\Stripe;


use App\Data\Price;
use Stripe\Transfer;

class StripeTransfer
{
    public function create(Price $amount, $account, $chargeId)
    {
        return Transfer::create([
            'amount' => $amount->inCents(),
            'currency' => 'usd',
            'source_transaction' => $chargeId,
            'destination' => $account
        ]);
    }
}
