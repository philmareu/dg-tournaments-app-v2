<?php

namespace App\Http\Controllers\Endpoints\Tournament;

use App\Http\Requests\Endpoints\Tournament\DestroyTournamentStripeAccountRequest;
use App\Http\Requests\Endpoints\Tournament\UpdateTournamentStripeAccountRequest;
use App\Models\Tournament;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TournamentStripeAccountEndpointController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
