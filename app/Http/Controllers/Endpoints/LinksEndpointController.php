<?php

namespace App\Http\Controllers\Endpoints;

use App\Http\Requests\Endpoints\Tournament\DestroyTournamentLinkRequest;
use App\Http\Requests\Endpoints\Tournament\StoreTournamentLinkRequest;
use App\Http\Requests\Endpoints\Tournament\UpdateTournamentLinkRequest;
use App\Models\Link;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class LinksEndpointController extends Controller implements HasMiddleware
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
