<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function likedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'route_user_likes');
    }

    public function isLikedByUser($userId): bool
    {
        return $this->likedByUsers()->where('user_id', $userId)->exists();
    }
}
