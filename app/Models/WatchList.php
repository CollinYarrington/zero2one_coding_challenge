<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WatchList extends Model
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
}
