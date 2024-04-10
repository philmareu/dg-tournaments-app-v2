<?php

namespace App\Http\Controllers\Endpoints;

use App\Http\Requests\Manager\DestroyTournamentLinkRequest;
use App\Http\Requests\Manager\StoreTournamentLinkRequest;
use App\Http\Requests\Manager\UpdateTournamentLinkRequest;
use App\Models\Link;
use App\Models\Tournament;
use App\Http\Controllers\Controller;

class LinksEndpointController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(StoreTournamentLinkRequest $request, Tournament $tournament)
    {
        $tournament->links()->create($request->only('title', 'url', 'ordinal'));

        return $tournament->links;
    }

    public function update(UpdateTournamentLinkRequest $request, Link $link)
    {
        $link->update($request->only('title', 'url', 'ordinal'));

        return $link->tournament->links;
    }

    public function destroy(DestroyTournamentLinkRequest $request, Link $link)
    {
        $link->delete();

        return $link->tournament->links;
    }
}
