<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddToWatchlistRequest;
use App\Models\Watchlist;
use App\Repositories\WatchlistRepository;
use App\Services\OmdbService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class MoviesController extends Controller
{
    protected $omdbService, $watchlistRepository;

    public function __construct(OmdbService $omdbService, WatchlistRepository $watchlistRepository)
    {
        $this->watchlistRepository = $watchlistRepository;
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

    public function addToWatchlist(AddToWatchlistRequest $request)
    {
        if ($this->watchlistRepository->addToWatchlist($request->all())) {
            return response()->json([
                'status' => 'success',
                'message' => 'Added to watchlist',
            ], Response::HTTP_OK);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to add movie to your watchlist'
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function getWatchList(Request $request)
    {
        $user = $request->user();
        $page = $request->input('page', 1);
        $watchlist = $this->watchlistRepository->getPaginatedWatchlist($user, 5, $page);

        return response()->json([
            'watchlist' => $watchlist,
        ]);
    }

    public function deleteFromWatchlist(Request $request)
    {
        $user = $request->user();
        $movie = $request->input('movie');
        $page = $request->input('page', 1);

        $this->watchlistRepository->deleteFromWatchlist($request->user(), $movie['imdb_id']);
        $watchlist = $this->watchlistRepository->getPaginatedWatchlist($user, 5, $page);

        return response()->json([
            'status' => 'success',
            'message' => 'Removed from watchlist',
            'watchlist' => $watchlist,
        ]);
    }

    public function view($imdb_id)
    {
        $movie = $this->omdbService->getAdditionalInfo($imdb_id);
        return Inertia::render('Dashboard/View', [
            'movie' => $movie
        ]);
    }
}
