<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\DifficultyLevel;

class LevelController extends Controller
{
    public function allDifficultyLevels()
    {
        try {

            $levels = DifficultyLevel::all();

            return response()->json([
                'status' => 200,
                'message' => 'Difficulty Levels Found Successfully',
                'data' => $levels
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage().' on line '.$e->getLine().' in file '.$e->getFile()], 500);
        }
    }

    public function getSingleDifficultyLevel($id)
    {
        try {

            $level = DifficultyLevel::find($id);
            if(!$level) {
                return response()->json([
                    'status' => 422,
                    'message' => 'Difficulty Level Not Found'
                ], 422);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Difficulty Level Found Successfully',
                'data' => $level
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage().' on line '.$e->getLine().' in file '.$e->getFile()], 500);
        }
    }
}