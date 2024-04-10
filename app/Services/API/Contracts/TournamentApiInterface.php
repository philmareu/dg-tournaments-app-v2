<?php

namespace App\Services\API\Contracts;


use Carbon\Carbon;
use App\Services\API\Responses\TournamentsResponse;

interface TournamentApiInterface
{
    public function getTournamentsByRange(Carbon $from, Carbon $to) : TournamentsResponse;
}
