<?php

namespace App\Models;

use App\Events\LinkSaved;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'url',
        'ordinal',
    ];

    protected $touches = [
        'tournament',
    ];

    protected $dispatchesEvents = [
        'created' => LinkSaved::class,
        'updated' => LinkSaved::class,
    ];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }
}
