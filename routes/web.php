<?php

use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('api/v1')->group(function () {
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
});

Route::get('/', function () {
    return view('index');
});

Route::any('{slug}', function () {
    return view('index');
});

