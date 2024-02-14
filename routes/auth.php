<?php

use App\Http\Controllers\API\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->controller(LoginController::class)->group(function (): void {
    Route::post('login', 'login');
    Route::get('google/callback', 'handleGoogleCallback');
});
