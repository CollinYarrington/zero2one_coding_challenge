<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddToWatchListRequest;
use App\Models\WatchList;
use App\Services\OmdbService;
use App\Services\WatchListService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class MoviesController extends Controller
{
    protected $omdbService, $watchListService;

    public function __construct(OmdbService $omdbService, WatchListService $watchListService)
    {
        $this->watchListService = $watchListService;
        $this->omdbService = $omdbService;
    }

    public function search(Request $request)
    {
        $searchResults = $this->omdbService->searchMovies($request);
        if (!$searchResults) {
            return back()->with('error', 'Failed to reach the OMDb API');
        }

        return response()->json(['message' => 'Success', 'data' => $searchResults]);
    }

    public function addToWatchList(AddToWatchListRequest $request)
    {
        if ($this->watchListService->addToWatchList($request)) {
            return response()->json(["status" => "success", "message" => "Added to watch list"], Response::HTTP_OK);
        }
        return response()->json(["status" => "", "message" => "Failed to add movie to your watch list"], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
