<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $touches = [
        'tournaments',
    ];

    public function tournaments()
    {
        return $this->belongsToMany(Tournament::class, 'class_tournament', 'class_id');
    }
}
