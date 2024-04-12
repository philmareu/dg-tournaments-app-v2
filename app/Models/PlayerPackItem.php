<?php

namespace App\Models;

use App\Events\PlayerPackItemSaved;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerPackItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
    ];

    protected $touches = [
        'playerPack',
    ];

    protected $dispatchesEvents = [
        'created' => PlayerPackItemSaved::class,
        'updated' => PlayerPackItemSaved::class,
    ];

    public function playerPack()
    {
        return $this->belongsTo(PlayerPack::class);
    }
}
