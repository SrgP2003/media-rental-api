<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\MediaController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\MediaAvailabilityController;
use App\Http\Controllers\Api\AuthController;

//Ruta para la autenticacion
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    //Rutas protegidas para Bookings / reservas
    Route::get('/bookings', [BookingController::class, 'index']);
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::get('/bookings/{booking}', [BookingController::class, 'show']);

    Route::patch(
        '/bookings/{booking}/status',
        [BookingController::class, 'updateStatus']
    );

    //Rutas protegidas para la gestion de clientes
    Route::get('/customers', [CustomerController::class, 'index']);
    Route::post('/customers', [CustomerController::class, 'store']);
    Route::get('/customers/{customer}', [CustomerController::class, 'show']);

    //Rutas protegidas para la gestion de medios
    Route::post('/media', [MediaController::class, 'store']);
    Route::put('/media/{media}', [MediaController::class, 'update']);
    Route::delete('/media/{media}', [MediaController::class, 'destroy']);
});

//Rutas publicas para la gestion de medios
Route::get('/media', [MediaController::class, 'index']);
Route::get('/media/{media}', [MediaController::class, 'show']);

//Ruta para verificar la disponibilidad de un medio
Route::get('/media/{media}/availability', [MediaAvailabilityController::class, 'check']);
