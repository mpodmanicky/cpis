<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use Illuminate\Http\JsonResponse;

class CarController extends Controller
{
    // api controller
    public function getCars() {
        $cars = Car::all();

        if($cars->isEmpty()) {
            return response()->json([
                'error' => 'No cars found in the database....'
            ], 404);
        } else {
            return response()->json([
                'message' => 'Siccessfully loaded cars from the db...',
                'data' => $cars
            ], 200);
        }
    }
}
