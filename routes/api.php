<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookingController;

/* Route::get('/ping', function () {
    return response()->json(['pong' => true]);
}); */

Route::get('/bookings', [BookingController::class, 'index']);
Route::post('/bookings', [BookingController::class, 'store']);
Route::get('/bookings/{booking}', [BookingController::class, 'show']);

Route::patch(
    '/bookings/{booking}/status',
    [BookingController::class, 'updateStatus']
);
