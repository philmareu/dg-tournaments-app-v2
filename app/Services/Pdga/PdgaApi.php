<?php

namespace App\Services\Pdga;

use App\Services\API\Contracts\CourseApiInterface;
use App\Services\API\Contracts\TournamentApiInterface;
use App\Services\API\Payloads\TournamentDataPayload;
use App\Services\API\Responses\CoursesResponse;
use App\Services\API\Responses\TournamentsResponse;
use App\Services\Pdga\EndPoints\Events;
use App\Services\Pdga\EndPoints\Players;
use App\Services\Pdga\Helpers\Courses;
use App\Services\Pdga\Helpers\PdgaTournamentPayloadBuilder;
use Carbon\Carbon;

class PdgaApi implements CourseApiInterface, TournamentApiInterface
{
    protected $batch = [];

    public function getTournamentsByRange(Carbon $from, Carbon $to): TournamentsResponse
    {
        $this->buildTournamentBatches($from, $to);

        $tournaments = collect($this->batch)->reject(function ($tournament) {
            return $tournament['tier'] == 'L' || $tournament['format'] == 'N';
        })->map(function ($tournament) {

            $payload = new TournamentDataPayload(PdgaTournamentPayloadBuilder::make($tournament)->payload());

            $payload->verifyPayload();

            return $payload;
        });

        return new TournamentsResponse(200, $tournaments);
    }

    //    public function getTournamentsFrom(Carbon $from) : Collection
    //    {
    //        $this->buildTournamentBatches($from);
    //
    //        return collect($this->batch)->reject(function($tournament) {
    //            return $tournament['tier'] == 'L';
    //        })->map(function($tournament) {
    //            return collect($tournament);
    //        });
    //    }

    public function getTournamentFields()
    {
        $api = new Events;
        $tournaments = $api->fromDate(Carbon::createFromDate(2017, 1, 1)->format('Y-m-d'))->limit(1)->offset(0)->get();

        return array_keys($tournaments[0]);
    }

    public function getPlayerByPdgaNumber($pdgaNumber)
    {
        $api = new Players;

        return $api->getByPdgaNumber($pdgaNumber);
    }

    protected function buildTournamentBatches(Carbon $from, Carbon $to, $offset = 0)
    {
        dump($offset.' - '.collect($this->batch)->last()['start_date']);
        $api = new Events;
        $tournaments = $api->fromDate($from->format('Y-m-d'))
            ->betweenDates($from->format('Y-m-d'), $to->format('Y-m-d'))
            ->limit(200)
            ->offset($offset)
            ->get();

        if (count($tournaments)) {
            $this->batch = array_merge($this->batch, $tournaments);
            $this->buildTournamentBatches($from, $to, $offset + 200);
        }
    }

    public function getCourses(): CoursesResponse
    {
        $course = new Courses();

        return $course->getCourses();
    }
}
