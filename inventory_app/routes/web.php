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
    Route::get('/unassignedParts', [PartController::class, 'getUnassignedParts']);
    Route::get('/assignedParts', [PartController::class, 'getAssignedParts']);
    Route::delete('/cars/{id}', [CarController::class, 'deleteCar']);
    Route::delete('/parts/{id}', [PartController::class, 'deletePart']);
    Route::post('/cars', [CarController::class, 'addCar']);
    Route::post('/parts', [PartController::class, 'addPart']);
});

Route::prefix('detail')->group(function() {
    Route::get('/car/{id}', [CarController::class, 'carDetail']);
    Route::patch('/car/{id}', [CarController::class, 'registerCar']);
    Route::patch('/assignPart', [PartController::class, 'assignPart']);
    Route::get('/assignedParts/{id}', [PartController::class, 'assignedPart']);
    Route::patch('/removePart/{id}', [PartController::class, 'removePart']);
});

require __DIR__.'/auth.php';
