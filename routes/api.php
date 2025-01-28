<?php

use App\Http\Controllers\News\NewsController;
use App\Http\Controllers\User\UserController;
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

Route::group(['prefix' => 'user'], function () {
    // Public routes (no authentication required)
    Route::post('register', [UserController::class, 'register']);
    Route::post('login', [UserController::class, 'login']);

    // Protected routes (require authentication)
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::post('add-to-favorites', [UserController::class, 'addToFavorites']);
        Route::delete('remove-from-favorites', [UserController::class, 'removeFromFavorites']);
    });
});

Route::prefix('news')->group(function () {
    Route::get('/', [NewsController::class, 'index']);
});






