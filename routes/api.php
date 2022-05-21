<?php

use App\Http\Controllers\BookingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ShowtimeController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('movies',MovieController::class);
Route::resource('showtimes',ShowtimeController::class);
Route::resource('bookings',BookingController::class);

/**
 * Registers new users
 * Requirements:
 * name, email, password, password_confirmation
 */
Route::post('/register',[RegisteredUserController::class, 'store'])->middleware(['guest']);
Route::post('/availableshowtimes/{id}',[MovieController::class,'getShowtimes']);