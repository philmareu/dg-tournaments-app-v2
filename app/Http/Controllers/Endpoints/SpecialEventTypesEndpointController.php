<?php

namespace App\Http\Controllers\Endpoints;

use App\Models\SpecialEventType;
use App\Http\Controllers\Controller;

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
