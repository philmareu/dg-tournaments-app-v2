<?php

namespace App\Http\Controllers\Endpoints;

use App\Models;
use App\Repositories\TournamentRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TournamentSurroundingCoursesEndpointController extends Controller
{
    protected $tournamentRepository;

    public function __construct(TournamentRepository $tournamentRepository)
    {
        $this->middleware('auth');
        $this->tournamentRepository = $tournamentRepository;
    }

    public function get(Tournament $tournament)
    {
        return $this->tournamentRepository->getSurroundingCourses($tournament);
    }
}
