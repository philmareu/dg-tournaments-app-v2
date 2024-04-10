<?php

namespace App\Http\Controllers\Endpoints;

use App\Http\Requests\Manager\StoreInformationRequest;
use App\Http\Requests\Manager\UpdateInformationRequest;
use App\Http\Resources\Tournament as TournamentResource;
use App\Models\Tournament;
use App\Models\Upload;
use App\Repositories\TournamentRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TournamentsEndpointController extends Controller
{
    protected $tournamentRepository;

    protected $upload;

    public function __construct(TournamentRepository $tournamentRepository, Upload $upload)
    {
        $this->tournamentRepository = $tournamentRepository;

        $this->middleware('auth')->except('index');
        $this->upload = $upload;
    }

    public function index(Tournament $tournament)
    {
        return new TournamentResource($tournament);
    }

    public function store(StoreInformationRequest $request)
    {
        $request->offsetSet('authorization_email', Auth::user()->email);

        $tournament = $this->tournamentRepository->createTournament(Auth::user(), $request->all());

        return new TournamentResource($tournament);
    }

    public function update(UpdateInformationRequest $request, Tournament $tournament)
    {
        if($tournament->sanctionedByPdga)
            $this->tournamentRepository->updateTournament(
                $tournament, Auth::user(), $request->except(['name', 'city', 'state_province', 'country', 'start', 'end'])
            );

        else $this->tournamentRepository->updateTournament($tournament, Auth::user(), $request->all());

        return new TournamentResource($tournament);
    }
}
