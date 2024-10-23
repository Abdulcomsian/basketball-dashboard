<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $role = Role::find(2);
            if ($role) {
                $user->roles()->attach($role->id);
            }
            $token = $user->createToken('myToken')->plainTextToken;

            return response()->json([
                'status' => 201,
                'message' => 'Register Successfully',
                'data' => $user,
                'token' => $token,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage() . ' on line ' . $e->getLine() . ' in file ' . $e->getFile()], 500);
        }
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        try {

            $user = User::where('email', $request->email)->first();
            if ($user) {
                if (!Hash::check($request->password, $user->password)) {
                    return response()->json([
                        'status' => 422,
                        'message' => 'Password did not match!'
                    ], 422);
                }

                $token = $user->createToken('myToken')->plainTextToken;

                return response()->json([
                    'status' => 200,
                    'message' => 'Login Successfully',
                    'data' => $user,
                    'token' => $token,
                ], 200);
            }

            return response()->json([
                'status' => 422,
                'message' => 'Email Not Found'
            ], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage() . ' on line ' . $e->getLine() . ' in file ' . $e->getFile()], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Successfully logged out',
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage() . ' on line ' . $e->getLine() . ' in file ' . $e->getFile()], 500);
        }
    }
}
