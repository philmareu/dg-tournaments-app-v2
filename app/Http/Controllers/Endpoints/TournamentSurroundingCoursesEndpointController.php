<?php

namespace App\Http\Controllers\Endpoints;

use App\Models\Tournament;
use App\Repositories\TournamentRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class TournamentSurroundingCoursesEndpointController extends Controller implements HasMiddleware
{
    protected $tournamentRepository;

    public function __construct(TournamentRepository $tournamentRepository)
    {
        $this->tournamentRepository = $tournamentRepository;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
        ];
    }

    public function get(Tournament $tournament)
    {
        return $this->tournamentRepository->getSurroundingCourses($tournament);
    }
}
