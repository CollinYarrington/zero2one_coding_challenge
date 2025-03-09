<?php

namespace App\Providers;

use App\Models\WatchList;
use App\Repositories\WatchListRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(WatchListRepository::class, function ($app) {
            return new WatchListRepository(new WatchList());
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
