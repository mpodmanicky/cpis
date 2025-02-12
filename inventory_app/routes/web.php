<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\CarController;

Route::get('/', function () {
    return Inertia::render('Home');
});

Route::get('/api/cars', [CarController::class, 'getCars']);

Route::get('/api/parts', function() {

});

require __DIR__.'/auth.php';
