<?php

namespace App\Models;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'query',
        'wants_notification',
        'searched_at',
        'frequency',
        'north',
        'east',
        'south',
        'west',
    ];

    protected $casts = [
        'searched_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
