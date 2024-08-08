<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'start',
        'end',
        'waypoints',
        'distance',
        'elevation_gain',
        'likes',
    ];

    protected $casts = [
        'waypoints' => 'array',  // Cast waypoints as an array
    ];
}
