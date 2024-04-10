<?php

namespace App\Services\API\Responses;

use App\Services\API\Payloads\TournamentDataPayload;
use App\Services\API\Exceptions\PayloadInvalidException;

class TournamentsResponse extends Response
{
    protected function verifyPayloads()
    {
        $this->payloads->each(function($payload) {
            if(! $payload instanceof TournamentDataPayload) throw new PayloadInvalidException();
        });
    }
}
