<?php

namespace App\Http\Controllers\Endpoints;

use App\Http\Requests\Endpoints\DestroyStripeAccountRequest;
use App\Models\StripeAccount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserStripeEndpointController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function destroy(DestroyStripeAccountRequest $request, StripeAccount $stripeAccount)
    {
        $stripeAccount->delete();

        return $request->user()->load('stripeAccounts')->stripeAccounts;
    }
}
