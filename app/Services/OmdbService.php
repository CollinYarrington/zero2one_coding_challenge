<?php

namespace App\Services;

use App\Repositories\WatchlistRepository;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Throwable;

class OmdbService
{
    /**
     * For more information on the OMDb API: 
     * https://www.omdbapi.com/
     */

    private $baseUrl;
    private $apiKey;
    private $client;
    protected $watchlistRepository;

    public function __construct(WatchlistRepository $watchlistRepository)
    {
        $this->baseUrl = config('omdb.url');
        $this->apiKey = config('omdb.key');
        $this->client = new Client();
        $this->watchlistRepository = $watchlistRepository;
    }

    public function searchMovies($request)
    {
        try {
            // This request fetches all the movies from the Omdb API
            $response = $this->client->get($this->baseUrl, [
                'query' => [
                    'apiKey' => $this->apiKey,
                    's' => $request->search,
                    'type' => 'movie',
                    'plot' => $request->plot ?? 'short',
                    'page' => $request->page,
                    'r' => 'json',
                ]
            ]);
            $currentWatchlist = $this->watchlistRepository->getWatchlist($request->user());
            $moviesData = json_decode($response->getBody()->getContents(), false);
            $movies['totalResults'] = $moviesData->totalResults;
            // Adding all the missing fields from the initial API call (rated, plot, runtime, genre).
            $movies['search'] = array_map(function ($movie) use ($currentWatchlist) {
                $additionalData = $this->getAdditionalInfo($movie->imdbID);
                $existsInWatchlist = $currentWatchlist->contains('imdb_id', $movie->imdbID);
                return [
                    'title' => $movie->Title,
                    'type' => $movie->Type,
                    'year' => $movie->Year,
                    'imdb_id' => $movie->imdbID,
                    'poster' => $movie->Poster,
                    'rated' => $additionalData['rated'],
                    'plot' => $additionalData['plot'],
                    'runtime' => $additionalData['runtime'],
                    'genre' => $additionalData['genre'],
                    'on_watchlist' => $existsInWatchlist

                ];
            }, $moviesData->Search);

            return $movies;
        } catch (Throwable $th) {
            Log::error($th);
            return false;
        }
    }

    public function getAdditionalInfo($imdbID)
    {
        try {
            $response = $this->client->post($this->baseUrl, [
                'query' => [
                    'apiKey' => $this->apiKey,
                    'i' => $imdbID,
                    'plot' => 'short',
                    'r' => 'json',
                ]
            ]);
            $movieData = json_decode($response->getBody()->getContents(), true);
            $movieData = array_change_key_case($movieData, CASE_LOWER);
            return $movieData;
        } catch (Throwable $th) {
            Log::error($th);
            return false;
        }
    }
}
