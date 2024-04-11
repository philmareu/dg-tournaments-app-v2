<?php

namespace App\Http\Controllers\Endpoints;

use App\Http\Requests\Endpoints\Tournament\DestroyTournamentPosterRequest;
use App\Http\Requests\UpdateTournamentPosterRequest;
use App\Models;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TournamentPosterEndpointController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
