<?php

namespace App\Http\Controllers\Endpoints;

use App\Http\Requests\Endpoints\DestroyStripeAccountRequest;
use App\Models\StripeAccount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserStripeEndpointController extends Controller implements HasMiddleware
{
    public function __construct()
    {
    }

    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
        ];
    }

    public function destroy(DestroyStripeAccountRequest $request, StripeAccount $stripeAccount)
    {
        $stripeAccount->delete();

        return $request->user()->load('stripeAccounts')->stripeAccounts;
    }
}
