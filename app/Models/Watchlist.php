<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Watchlist extends Model
{
    protected $fillable = [
        'user_id',
        'imdb_id',
        'title',
        'type',
        'year',
        'poster',
        'rated',
        'plot',
        'runtime',
        'genre'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
