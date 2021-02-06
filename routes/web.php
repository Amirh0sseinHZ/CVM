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
    Route::get('reservation/{id}', [ReservationController::class, 'show']);
    Route::post('reservation', [ReservationController::class, 'store']);
});

Route::get('/', function () {
    return view('index');
});

Route::any('{slug}', function () {
    return view('index');
});

