<?php

namespace App\Repositories;

use App\Models\WatchList;

class WatchListRepository extends BaseRepository
{
    public function __construct(WatchList $watchList)
    {
        parent::__construct($watchList);
    }

    public function addToWatchList($data)
    {
        return $this->model->create($data);
    }
}
