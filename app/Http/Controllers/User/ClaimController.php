<?php

namespace App\Http\Controllers\User;

use App\Events\TournamentClaimApproved;
use App\Repositories\ClaimRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClaimController extends Controller
{
    protected $claimRepository;

    public function __construct(ClaimRepository $claimRepository)
    {
        $this->claimRepository = $claimRepository;
    }

    public function viewClaim($token)
    {
        $claim = $this->claimRepository->getClaimByToken($token);

        if(is_null($claim)) abort(404);

        return view('pages.claim.view')
            ->with('claim', $claim);
    }

    public function processClaim($token)
    {
        $claim = $this->claimRepository->getClaimByToken($token);
        $claim->tournament->managers()->attach($claim->user);

        event(new TournamentClaimApproved($claim->user, $claim->tournament));

        return response()->json(['success' => 'User added as manager to tournament.'], 200);
    }
}
