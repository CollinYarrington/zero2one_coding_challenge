<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WatchListController;
use App\Http\Middleware\Authenticated;
use Illuminate\Support\Facades\Route;

use Inertia\Inertia;

Route::get('/', function () {
    return to_route('auth.create');
});

Route::group(['as' => 'auth.'], function () {
    Route::get('/login', [AuthenticationController::class, 'create'])->name('create');
    Route::post('/login', [AuthenticationController::class, 'store'])->name('store');
});
