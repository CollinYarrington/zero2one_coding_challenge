<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Watchlist;

class WatchlistRepository extends BaseRepository
{
    public function __construct(Watchlist $watchlist)
    {
        parent::__construct($watchlist);
    }

    public function addToWatchlist($data)
    {
        return $this->model->create($data);
    }

    public function getPaginatedWatchlist(User $user, $items_per_page = 5, $page)
    {
        return $user->watchlist()->orderBy('created_at', 'desc')->paginate($items_per_page, ['*'], 'page', $page);
    }

    public function deleteFromWatchlist(User $user, $imdb_id)
    {
        $user->watchlist()->where('imdb_id', $imdb_id)->delete();
        // return $this->getPaginatedWatchlist($user, $items_per_page, $page);
    }

    public function getWatchlist(User $user)
    {
        return $user->watchlist()->get();
    }
}
