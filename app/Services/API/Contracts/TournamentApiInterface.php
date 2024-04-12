<?php

namespace App\Services\API\Contracts;

use App\Services\API\Responses\TournamentsResponse;
use Carbon\Carbon;

interface TournamentApiInterface
{
    public function getTournamentsByRange(Carbon $from, Carbon $to): TournamentsResponse;
}
