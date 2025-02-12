<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Part;

class PartController extends Controller
{
    //
    public function getParts() {
        $parts = Part::all();

        if($parts->isEmpty()) {
            return response()->json([
                'error' => 'No parts found in the db...'
            ], 404);
        } else {
            return response()->json([
                'message' => 'Successfully loaded parts from the db...',
                'data' => $parts
            ], 200);
        }
    } 
}
