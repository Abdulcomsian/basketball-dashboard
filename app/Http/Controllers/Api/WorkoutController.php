<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\WorkoutLength;

class WorkoutController extends Controller
{
    public function allWorkouts()
    {
        try {

            $workouts = WorkoutLength::all();

            return response()->json([
                'status' => 200,
                'message' => 'Workout Lengths Found Successfully',
                'data' => $workouts
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage().' on line '.$e->getLine().' in file '.$e->getFile()], 500);
        }
    }

    public function getSingleWorkout($id)
    {
        try {

            $workout = WorkoutLength::find($id);
            if(!$workout) {
                return response()->json([
                    'status' => 422,
                    'message' => 'Workout Length Not Found'
                ], 422);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Workout Length Found Successfully',
                'data' => $workout
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage().' on line '.$e->getLine().' in file '.$e->getFile()], 500);
        }
    }
}