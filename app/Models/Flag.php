<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flag extends Model
{
    use HasFactory;

    protected $fillable = [
        'tournament_id',
        'flag_type_id',
        'notes',
        'review_on',
    ];

    protected $casts = [
        'review_on' => 'datetime',
    ];

    public function flagType()
    {
        return $this->belongsTo(FlagType::class);
    }

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }
}
