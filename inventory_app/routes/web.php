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
});

require __DIR__.'/auth.php';
