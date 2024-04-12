<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiRequests extends Model
{
    protected $fillable = [
        'provider',
        'type',
    ];
}
