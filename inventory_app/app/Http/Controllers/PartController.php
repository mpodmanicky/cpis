<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Part;

class PartController extends Controller
{
    //
    public function getParts() {
        $parts = Part::orderBy('name', 'asc')->get();

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
    public function getUnassignedParts() {
        $parts = Part::whereNull('car_id')->get();

        if($parts->isEmpty()) {
            return response()->json([
                'error' => 'Error while fetching parts...'
            ], 400);
        } else {
            return response()->json([
                'message' => 'Loaded unassigned car parts....',
                'data' => $parts,
            ], 200);
        }
    }

    public function getAssignedParts() {
        $parts = Part::whereNotNull('car_id')->get();
        
        if($parts) {
            return response()->json([
                'message' => 'loaded assigned parts',
                'data' => $parts,
            ], 200);
        } else {
            return response()->json([
                'error' => 'Could not load parts...'
            ], 404);
        }
    }

    public function assignPart(Request $request) {
        $part = Part::find($request['part']);

        if($part) {
            $part->car_id = $request['car'];
            $part->save();
            
            return response()->json([
                'message' => 'part added...',
            ], 200);
        } else {
            return response()->json([
                'error' => 'error while searching for the part...'
            ], 400);
        }
    }

    public function assignedPart($id) {
        $parts = Part::where('car_id', $id)->get();

        if($parts->isEmpty()) {
             return response()->json([
                'error' => 'Error while fetching parts'
            ], 404);
        } else {
            return response()->json([
                'message' => 'Fetched parts...',
                'data' => $parts,
            ], 200);
        }
    }

    public function removePart($id) {
        $part = Part::find($id);

        if($part) {
            $part->car_id = null;
            $part->save();

            return response()->json([
                'message' => 'part removed successfully'
            ], 200);
        } else {
            return response()->json([
                'error' => 'part not removed'
            ], 400);
        }
    }

    public function deletePart($id) {
        $part = Part::find($id);

        if($part) {
            $part->delete();

            return response()->json([
                'message' => 'Part deleted successfully...'
            ], 200);
        } else {
            return response()->json([
                'error' => 'Error while deleting...'
            ], 404);
        }
    }

    public function addPart(Request $request) {
        $name = $request['name'];
        $serialNumber = $request['serialnumber'];

        $part = new Part();
        $part->name = $name;
        $part->serialnumber = $serialNumber;
        $part->save();

        return response()->json(['message' => 'Part added to db'], 200);
    }
}
