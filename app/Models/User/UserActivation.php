<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserActivation extends Model
{
    protected $fillable = [
        'token',
    ];
}
