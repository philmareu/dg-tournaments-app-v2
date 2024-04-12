<?php

namespace App\Models;

use App\Collections\OrderSponsorshipsCollection;
use App\Data\Price;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderSponsorship extends Model
{
    use HasFactory;

    protected $fillable = [
        'cost',
    ];

    protected $appends = [
        'cost_in_dollars',
    ];

    public function newCollection(array $models = [])
    {
        return new OrderSponsorshipsCollection($models);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function sponsorship()
    {
        return $this->belongsTo(Sponsorship::class);
    }

    public function transfer()
    {
        return $this->belongsTo(Transfer::class);
    }

    public function setCostAttribute($value)
    {
        $currency = new Price($value, 'dollars');

        $this->attributes['cost'] = $currency->inCents();
    }

    public function getCostAttribute($value)
    {
        return new Price($value);
    }

    public function getCostInDollarsAttribute()
    {
        return $this->cost->inDollars();
    }
}
