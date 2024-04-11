<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerPack extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description'
    ];

    protected $touches = [
        'tournament'
    ];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function items()
    {
        return $this->hasMany(PlayerPackItem::class, 'player_pack_id');
    }
}
