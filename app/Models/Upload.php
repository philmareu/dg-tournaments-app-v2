<?php

namespace App\Models;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
        'title',
        'size',
        'alt',
        'mime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
