<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Repositories\TournamentRepository;

class WeatherController extends Controller
{
    protected $tournamentRepository;

    public function __construct(TournamentRepository $tournamentRepository)
    {
        $this->tournamentRepository = $tournamentRepository;
    }

    public function tournament(Tournament $tournament)
    {
        return $this->tournamentRepository->getWeather($tournament);
    }
}
