<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Part;
use Illuminate\Http\JsonResponse;
use Inertia\Inertia;

class CarController extends Controller
{
    // api controller
    public function getCars() {
        $cars = Car::orderBy('name', 'asc')->get();

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

    public function carDetail($id) {
        $car = Car::find($id);

        if($car) {
            return Inertia::render('Components/Car', ['car' => $car ]);
        }
    }

    public function registerCar(Request $request, $id) {
        $car = Car::find($id);

        if($car) {
            $car->registration_number = $request['registration_number'];
            $car->is_registered = $request['is_registered'];
            $car->name = $request['name'];
            $car->save();

            return response()->json([
                'message' => 'Car variables were successfully updated...'
            ], 200);
        } else {
            return response()->json([
                'error' => 'error while updating the car...'
            ], 400);
        }
    }

    public function deleteCar($id) {
        $car = Car::find($id);

        if($car) {
            Part::where('car_id', $id)->update(['car_id' => null]);
            $car->delete();
            
            return response()->json([
                'message' => 'Car deleted successfully...'
            ], 200);
        } else {
            return response()->json([
                'error' => 'Error while deleting...'
            ], 404);
        }
    }

    public function addCar(Request $request) {
        $carName = $request['name'];
        $isRegistered = $request['registered'];
        $registrationNumber = $isRegistered? $request['registration_number'] : null;

        $car = new Car();
        $car->name = $carName;
        $car->is_registered = $isRegistered;
        $car->registration_number = $registrationNumber;
        $car->save();
        
        return response()->json([
            'message' => 'Car has been successfully added to db....'
        ], 200);
    }
}
