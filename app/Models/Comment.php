<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

//Tässä määritetään tietokannan komentti-taulukon suhteita
class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'route_id', 'content'];

    public function route(): BelongsTo {
        return $this->belongsTo(Route::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
