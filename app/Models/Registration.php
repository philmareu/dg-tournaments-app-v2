<?php

namespace App\Models;

use App\Events\TournamentRegistrationUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'opens_at',
        'closes_at',
        'url'
    ];

    protected $casts = [
        'opens_at' => 'datetime',
        'closes_at' => 'datetime',
    ];

    protected $touches = [
        'tournament'
    ];

    protected $dispatchesEvents = [
        'created' => TournamentRegistrationUpdated::class,
        'updated' => TournamentRegistrationUpdated::class
    ];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }
}
