<?php

namespace App\Models;

use App\Collections\OrderCollection;
use App\Data\Price;
use App\Models\Charge;
use App\Models\Registration;;
use App\Models\Sponsorship;
use App\Models\TournamentOrder;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use function foo\func;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'unique',
        'email',
        'first_name',
        'last_name'
    ];

    protected $appends = [
        'total_quantity',
        'total_in_dollars',
        'total_in_cents'
    ];

    public function sponsorships()
    {
        return $this->hasMany(OrderSponsorship::class);
    }

    public function charges()
    {
        return $this->hasMany(Charge::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Guest User',
            'first_name' => 'Guest',
            'last_name' => 'User',
            'email' => 'guest@guest.com'
        ]);
    }

    public function getTotalAttribute()
    {
        return Price::make($this->sponsorships->reduce(function($carry, OrderSponsorship $orderSponsorship) {
            return $carry + $orderSponsorship->cost->inCents();
        }, 0));
    }

    public function getTotalInDollarsAttribute()
    {
        return $this->total->inDollars();
    }

    public function getTotalInCentsAttribute()
    {
        return $this->total->inCents();
    }

    public function getTotalQuantityAttribute()
    {
        return $this->sponsorships->count();
    }









//
//
//    public function registrations()
//    {
//        return $this->belongsToMany(Registration::class)->withPivot('cost');
//    }
//

//
//    public function getCostAttribute($value)
//    {
//        return new Price($value);
//    }
//
//    public function setCostAttribute($value)
//    {
//        $currency = new Price($value, 'dollars');
//
//        $this->attributes['cost'] = $currency->inCents();
//    }
//
//
//

//

//
//    public function tournamentOrders()
//    {
//        return $this->hasMany(TournamentOrder::class);
//    }
//
//    /* Saving methods */
//
//    public function removeSponsorshipProduct(OrderSponsorshipProduct $orderSponsorshipProduct)
//    {
//        return $this->sponsorships->where('id', $orderSponsorshipProduct->id)->first()->delete();
//    }

}
