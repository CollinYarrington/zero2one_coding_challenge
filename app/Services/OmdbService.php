<?php

namespace App\Services;

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

    public function __construct()
    {
        $this->baseUrl = config('omdb.url');
        $this->apiKey = config('omdb.key');
        $this->client = new Client();
    }

    public function searchMovies($request)
    {
        try {

            // This request fetches all the movies from the Omdb API
            $response = $this->client->get($this->baseUrl, [
                'query' => [
                    'apiKey' => $this->apiKey,
                    's' => $request->search,
                    'plot' => $request->plot ?? 'short',
                    'page' => $request->page,
                    'r' => 'json',
                ]
            ]);

            $moviesData = json_decode($response->getBody()->getContents(), false);

            $movies['totalResults'] = $moviesData->totalResults;
            // Adding all the missing fields from the initial API call (rated, plot, runtime, genre).
            $movies['search'] = array_map(function ($movie) {
                $additionalData = $this->getAdditionalInfo($movie->imdbID);
                return [
                    'title' => $movie->Title,
                    'type' => $movie->Type,
                    'year' => $movie->Year,
                    'imdb_id' => $movie->imdbID,
                    'poster' => $movie->Poster,
                    'rated' => $additionalData['Rated'],
                    'plot' => $additionalData['Plot'],
                    'runtime' => $additionalData['Runtime'],
                    'genre' => $additionalData['Genre'],

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
            return $movieData;
        } catch (Throwable $th) {
            Log::error($th);
            return false;
        }
    }
}
