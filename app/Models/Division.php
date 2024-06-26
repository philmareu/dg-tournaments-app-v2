<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function tournaments()
    {
        return $this->belongsToMany(Tournament::class);
    }
}
