<?php namespace App\Services\Foursquare\EndPoints\Venues;

use App\Services\Foursquare\Http\Get;
use App\Services\Foursquare\Http\Url;

class Venue extends Get
{
    public function whereId($venueId)
    {
        return $this->sendRequest(new Url('venues/' . $venueId));
    }
}
