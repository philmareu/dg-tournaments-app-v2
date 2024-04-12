<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Format extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'title',
    ];

    public function tournament()
    {
        return $this->hasMany(Tournament::class);
    }
}
