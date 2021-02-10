<?php

use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SpecialistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {

    Route::prefix('reservations')->group(function () {
        Route::post('/', [ReservationController::class, 'store']);
        Route::get('/{code}', [ReservationController::class, 'show'])
            ->where('code', '^([1-9]\d{0,}-[1-9]\d{0,})$');
        Route::put('/{code}/handle', [ReservationController::class, 'handle'])
            ->where('code', '^([1-9]\d{0,}-[1-9]\d{0,})$');
        Route::put('/{code}/end', [ReservationController::class, 'end'])
            ->where('code', '^([1-9]\d{0,}-[1-9]\d{0,})$');
        Route::put('/{code}/cancel', [ReservationController::class, 'cancel'])
            ->where('code', '^([1-9]\d{0,}-[1-9]\d{0,})$');
    });

    Route::prefix('specialists')->group(function () {
        Route::get('/', [SpecialistController::class, 'index']);
        Route::get('/{id}', [SpecialistController::class, 'show']);
    });

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        Route::get('/reservations', [ReservationController::class, 'index']);
    });

});
