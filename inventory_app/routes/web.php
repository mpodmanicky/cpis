<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\CarController;
use App\Http\Controllers\PartController;

Route::get('/', function () {
    return Inertia::render('Home');
});

Route::prefix('api')->group(function() {
    Route::get('/cars', [CarController::class, 'getCars']);
    Route::get('/parts', [PartController::class, 'getParts']);
    Route::delete('/cars/{id}', [CarController::class, 'deleteCar']);
});

Route::prefix('detail')->group(function() {
    Route::get('/car/{id}', [CarController::class, 'carDetail']);
    Route::patch('/car/{id}', [CarController::class, 'registerCar']);
});

require __DIR__.'/auth.php';
