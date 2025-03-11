<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MoviesController;
use App\Http\Controllers\WatchlistController;
use App\Http\Middleware\Authenticated;
use Illuminate\Support\Facades\Route;

use Inertia\Inertia;

Route::get('/', function () {
    return to_route('auth.create');
});

Route::group(['as' => 'auth.'], function () {
    Route::get('/login', [AuthenticationController::class, 'create'])->name('create');
    Route::post('/login', [AuthenticationController::class, 'store'])->name('store');
    Route::post('/logout', [AuthenticationController::class, 'destroy'])->name('destroy');
});

Route::group(['middleware' => [Authenticated::class]], function () {

    Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
    });

    Route::group(['prefix' => 'movies', 'as' => 'movie.'], function () {
        // Route::get('', [MoviesController::class, 'index'])->name('list');
        // Route::get('/view/{imdbID}', [MoviesController::class, 'view'])->name('view');
        Route::post('/search', [MoviesController::class, 'search'])->name('search');

        Route::get('/watch-list', [MoviesController::class, 'getWatchList'])->name('watchlist');
        Route::post('/watch-list/add', [MoviesController::class, 'addToWatchlist'])->name('watchlist.add');
        Route::post('/watch-list/delete', [MoviesController::class, 'deleteFromWatchlist'])->name('watchlist.delete');
    });
});

// Route::post('/search', [DashboardController::class, 'search'])->name('search')
