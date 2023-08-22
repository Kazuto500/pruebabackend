<?php

use App\Http\Controllers\ActionPowerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BoxController;
use App\Http\Controllers\PersonalAccessTokensController;
use App\Http\Controllers\PowerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StepsController;
use App\Models\ActionPower;
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

Route::post('register', [AuthController::class, 'register']);

Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('users', [AuthController::class, 'index']);
    Route::post('logout', [AuthController::class, 'logout']);

    Route::prefix('boxes')->group(function () {
        Route::get('/', [BoxController::class, 'index']);
        Route::post('/', [BoxController::class, 'store']);
        Route::put('/{box}', [BoxController::class, 'update']);
        Route::delete('/{box}', [BoxController::class, 'destroy']);

        Route::prefix('{box}')->group(function () {
            Route::prefix('powers')->group(function () {
                Route::get('/', [PowerController::class, 'index']);
                Route::post('/', [PowerController::class, 'store']);
                Route::put('/{power}', [PowerController::class, 'update']);
                Route::delete('/{power}', [PowerController::class, 'destroy']);

                Route::prefix('{power}')->group(function () {
                    Route::prefix('steps')->group(function () {
                        Route::get('/', [StepsController::class, 'index']);
                        Route::post('/', [StepsController::class, 'store']);
                        Route::put('/{step}', [StepsController::class, 'update']);
                        Route::delete('/{step}', [StepsController::class, 'destroy']);
                    });
                });
            });
        });
    });
});
