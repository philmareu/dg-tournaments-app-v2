<?php

namespace App\Http\Controllers\Endpoints;

use App\Http\Requests\Endpoints\Tournament\DestroyTournamentStripeAccountRequest;
use App\Http\Requests\Endpoints\Tournament\UpdateTournamentStripeAccountRequest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class TournamentStripeAccountEndpointController extends Controller implements HasMiddleware
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

    public function update(UpdateTournamentStripeAccountRequest $request, Tournament $tournament)
    {
        $tournament->stripe_account_id = $request->stripe_account_id;
        $tournament->save();

        return $tournament->load('stripeAccount')->stripeAccount;
    }

    public function destroy(DestroyTournamentStripeAccountRequest $request, Tournament $tournament)
    {
        $tournament->stripe_account_id = null;
        $tournament->save();

        return $tournament->load('stripeAccount')->stripeAccount;
    }
}
