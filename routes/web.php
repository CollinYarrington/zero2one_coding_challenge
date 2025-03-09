<?php

use App\Http\Controllers\AuthenticationController;
use Illuminate\Support\Facades\Route;

use Inertia\Inertia;

Route::get('/', function () {
    return to_route('login.attempt');
});

Route::group(['prefix' => 'login', 'as' => 'login.'], function () {
    Route::get('/', [AuthenticationController::class, 'create']);
    Route::post('/', [AuthenticationController::class, 'store'])->name('attempt');
});
