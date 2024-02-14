<?php

use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\ListController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(ListController::class)->prefix('list')->group(function () {
        Route::get('courses', 'courses');
        Route::get('lessons-by-course/{courseId}', 'lessonsByCourse');
    });
});
