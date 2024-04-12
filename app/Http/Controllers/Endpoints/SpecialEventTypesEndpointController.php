<?php

namespace App\Http\Controllers\Endpoints;

use App\Http\Controllers\Controller;
use App\Models\SpecialEventType;

class SpecialEventTypesEndpointController extends Controller
{
    protected $specialEventType;

    public function __construct(SpecialEventType $specialEventType)
    {
        $this->specialEventType = $specialEventType;
    }

    public function list()
    {
        return $this->specialEventType->all();
    }
}
