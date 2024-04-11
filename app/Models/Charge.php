<?php

namespace App\Models;

use App\Data\Price;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{
    use HasFactory;

    protected $fillable = [
        'charge_id',
        'status',
        'amount'
    ];

    public function getAmountAttribute($value)
    {
        return Price::make($value);
    }
}
