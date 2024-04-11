<?php

namespace App\Models;

use App\Events\TournamentFollowed;
use App\Events\TournamentUnfollowed;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    protected $dispatchesEvents = [
        'created' => TournamentFollowed::class,
        'deleting' => TournamentUnfollowed::class
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function resource()
    {
        return $this->morphTo();
    }
}
