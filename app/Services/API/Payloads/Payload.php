<?php

namespace App\Services\API\Payloads;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

abstract class Payload extends Collection implements Arrayable
{
    protected $keys = [];

    public function __construct($items)
    {
        parent::__construct($items);
    }

    abstract protected function verifyPayload();
}
