<?php

namespace App\Collections;

use App\Models\OrderSponsorship;
use Illuminate\Database\Eloquent\Collection;

class OrderSponsorshipsCollection extends Collection
{
    public function sortSponsorshipsByTournament()
    {
        return $this->groupBy(function (OrderSponsorship $orderSponsorship) {
            return $orderSponsorship->sponsorship->tournament_id;
        });
    }
}
