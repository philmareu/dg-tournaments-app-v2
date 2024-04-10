<?php

namespace App\Billing\Stripe;

use App\Data\Price;
use Illuminate\Support\Facades\Log;
use Stripe\Charge;

class StripeCharge
{
    public function create(Price $price, $transferGroup, $token, $customerId = null)
    {
        return Charge::create([
            'amount' => $price->inCents(),
            'currency' => 'usd',
            'transfer_group' => $transferGroup,
            'source' => $token,
            'customer' => $customerId
        ]);
    }
}
