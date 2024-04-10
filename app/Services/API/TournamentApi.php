<?php

namespace App\Services\API;


use Carbon\Carbon;
use App\Models\DataSource;
use App\Services\API\Contracts\CourseApiInterface;
use App\Services\API\Contracts\TournamentApiInterface;
use App\Services\API\Responses\CoursesResponse;
use App\Services\API\Responses\TournamentsResponse;

class TournamentApi implements TournamentApiInterface
{
    protected $channelApi;

    public function __construct(DataSource $dataSource)
    {
        $apiClass = $dataSource->api_class;
        $this->channelApi = new $apiClass;
    }

    static public function make(DataSource $dataSource)
    {
        return new static($dataSource);
    }

    public function getTournamentsByRange(Carbon $from, Carbon $to) : TournamentsResponse
    {
        return $this->channelApi->getTournamentsByRange($from, $to);
    }
}
