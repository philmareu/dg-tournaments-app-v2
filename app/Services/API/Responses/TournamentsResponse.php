<?php

namespace App\Services\API\Responses;

use App\Services\API\Exceptions\PayloadInvalidException;
use App\Services\API\Payloads\TournamentDataPayload;

class TournamentsResponse extends Response
{
    protected function verifyPayloads()
    {
        $this->payloads->each(function ($payload) {
            if (! $payload instanceof TournamentDataPayload) {
                throw new PayloadInvalidException();
            }
        });
    }
}
