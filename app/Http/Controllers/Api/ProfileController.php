<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function getProfile()
    {
        try {
            $user = Auth::user();

            return response()->json([
                'status' => 200,
                'message' => 'success',
                'data' => $user
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage() . ' on line ' . $e->getLine() . ' in file ' . $e->getFile()], 500);
        }
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users,username,' . auth()->id(),
                'password' => 'nullable|string|min:8|confirmed',
            ]);
            
            try {
            $user = Auth::user();
            $user->name = $request->input('name');
            $user->username = $request->input('username');

            if ($request->filled('password')) {
                $user->password = bcrypt($request->input('password'));
            }

            $user->save();

            return response()->json([
                'status' => 200,
                'message' => 'success',
                'data' => $user
            ], 200);
        } catch (Exception $e) {
            Log::error('Failed to update profile: ' . $e->getMessage());

            return response()->json(['error' => $e->getMessage() . ' on line ' . $e->getLine() . ' in file ' . $e->getFile()], 500);
        }
    }
}
