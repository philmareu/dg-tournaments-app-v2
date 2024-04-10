<?php

namespace App\Services\API\Responses;


use App\Services\API\Exceptions\PayloadInvalidException;
use App\Services\API\Payloads\CourseDataPayload;

class CoursesResponse extends Response
{
    protected function verifyPayloads()
    {
        $this->payloads->each(function($payload) {
            if(! $payload instanceof CourseDataPayload) throw new PayloadInvalidException();
        });
    }
}
