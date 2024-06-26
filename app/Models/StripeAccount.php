<?php

namespace App\Models;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StripeAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'access_token',
        'display_name',
        'stripe_user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
