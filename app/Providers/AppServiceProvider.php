<?php

namespace App\Providers;

use App\Models\Watchlist;
use App\Repositories\WatchlistRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(WatchlistRepository::class, function ($app) {
            return new WatchlistRepository(new Watchlist());
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
