<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_lat',
        'start_lng',
        'end_lat',
        'end_lng',
        'waypoints',
        'distance',
        'elevation_gain',
    ];

    protected $casts = [
        'waypoints' => 'array',  // Cast waypoints as an array
    ];
}
