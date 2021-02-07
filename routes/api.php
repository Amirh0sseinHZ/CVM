<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpecialistController;
use App\Http\Controllers\ReservationController;

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
        /* Todo: protect the route */
        Route::get('/', [ReservationController::class, 'index']);
        /***************************/
        Route::post('/', [ReservationController::class, 'store']);
        Route::get('/{code}', [ReservationController::class, 'show'])
            ->where('code', '^([1-9]\d{0,}_[1-9]\d{0,})$');
        Route::put('/{code}/cancel', [ReservationController::class, 'cancel'])
            ->where('code', '^([1-9]\d{0,}_[1-9]\d{0,})$');
    });
    Route::prefix('specialists')->group(function () {
        Route::get('/', [SpecialistController::class, 'index']);
        Route::get('/{id}', [SpecialistController::class, 'show']);
    });
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
    });
});
