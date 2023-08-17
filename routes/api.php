<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\UserController;
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

Route::prefix('v1')->group(function () {
    Route::post('/register', [UserController::class, 'register'])
        ->middleware('guest')
        ->name('register');

    Route::post('/login', [UserController::class, 'login'])
        ->middleware('guest')
        ->name('login');

    Route::delete('/logout', [UserController::class, 'logout'])
        ->middleware('auth:sanctum')
        ->name('logout');

    Route::middleware('auth:sanctum')->group(function () {
        Route::prefix('images')->group(function () {
            Route::get('/', [ImageController::class, 'index']);
            Route::get('/{image}', [ImageController::class, 'show']);
            Route::post('/', [ImageController::class, 'store']);
            Route::put('/{image}', [ImageController::class, 'update']);
            Route::delete('/{image}', [ImageController::class, 'destroy']);
            Route::delete('/{image}/force', [ImageController::class, 'forceDestroy']);
            Route::patch('/{image}/favourite', [ImageController::class, 'favourite']);
        });
    });
});
