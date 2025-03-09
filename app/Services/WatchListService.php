<?php

namespace App\Services;

use App\Models\WatchList;
use App\Repositories\WatchListRepository;
use Illuminate\Support\Facades\Log;

class WatchListService
{
    protected $watchListRepository;

    public function __construct(WatchListRepository $watchListRepository)
    {
        $this->watchListRepository = $watchListRepository;
    }

    public function addToWatchList($request)
    {
        $data = $request->all();
        $data['user_id'] = $request->user()->id;
        $watchList = $this->watchListRepository->addToWatchList($data);
        return $watchList;
    }
}
