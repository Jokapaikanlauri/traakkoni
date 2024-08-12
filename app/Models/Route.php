<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start',
        'end',
        'waypoints',
        'distance',
        'elevation_gain',
        'likes',
    ];

    protected $casts = [
        'waypoints' => 'array',
    ];

    // Define the many-to-many relationship with users who liked the route
    public function likedByUsers() {
        return $this->belongsToMany(User::class, 'route_user_likes');
    }

    public function isLikedByUser($userId): bool {
        return $this->likedByUsers()->where('user_id', $userId)->exists();
    }

    // Define the one-to-many relationship with comments
    public function comments(): HasMany {
        return $this->hasMany(Comment::class);
    }
}
