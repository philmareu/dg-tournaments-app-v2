<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataSource extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'retrieved_at'
    ];

    protected $dates = [
        'retrieved_at'
    ];

    public function tournaments()
    {
        return $this->hasMany(Tournament::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
