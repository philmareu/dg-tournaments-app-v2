<?php

namespace App\Http\Controllers\Endpoints;

use App\Http\Controllers\Controller;
use App\Http\Requests\Endpoints\Tournament\DestroySponsorshipRequest;
use App\Http\Requests\Endpoints\Tournament\StoreSponsorshipRequest;
use App\Http\Requests\Endpoints\Tournament\UpdateSponsorshipRequest;
use App\Models\Sponsorship;
use App\Models\Tournament;

class SponsorshipsEndpointController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSponsorshipRequest $request, Tournament $tournament)
    {
        $request->offsetSet('cost', $request->cost_in_dollars);
        $tournament->sponsorships()->create($request->all());
        $tournament->searchable();

        return $tournament->load('sponsorships')->sponsorships;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSponsorshipRequest $request, Sponsorship $sponsorship)
    {
        $sponsorship->update($request->except('cost'));
        $sponsorship->update(['cost' => $request->cost_in_dollars]);
        $sponsorship->tournament->searchable();

        return $sponsorship->tournament->load('sponsorships')->sponsorships;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroySponsorshipRequest $request, Sponsorship $sponsorship)
    {
        $tournament = $sponsorship->tournament;
        $sponsorship->delete();
        $tournament->searchable();

        return $sponsorship->tournament->load('sponsorships')->sponsorships;
    }
}
