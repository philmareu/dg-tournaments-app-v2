<?php

namespace App\Http\Controllers\Endpoints;

use App\Http\Controllers\Controller;
use App\Http\Requests\Endpoints\Tournament\DestroyTournamentPosterRequest;
use App\Http\Requests\UpdateTournamentPosterRequest;
use App\Models\Tournament;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class TournamentPosterEndpointController extends Controller implements HasMiddleware
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

    public function update(UpdateTournamentPosterRequest $request, Tournament $tournament)
    {
        $tournament->update(['poster_id' => $request->upload_id]);

        return $tournament->load('poster')->poster;
    }

    public function destroy(DestroyTournamentPosterRequest $request, Tournament $tournament)
    {
        $tournament->poster->delete();

        return $tournament->load('poster')->poster;
    }
}
