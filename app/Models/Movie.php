<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'id',
        'title',
        'overview',
        'genres',
        'poster',
        'release_date',
    ];

    protected $casts = [
        'release_date' => 'datetime',
        'genres' => 'array',
    ];
}
