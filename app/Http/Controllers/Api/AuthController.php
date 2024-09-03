<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        //Validate Request
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        try {

            if(Auth::attempt($request->only('email','password'))) {
                $user = Auth::user();
                $token = $user->createToken('auth token')->plainTextToken;

                return response()->json([
                    'status' => 200,
                    'message' => 'Login Successfully',
                    'user' => $user,
                    'token' => $token
                ],200);
            }

            return response()->json([
                'status' => 422,
                'message' => 'Invalid Credentials',
            ],422);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage() . ' on line ' . $e->getLine() . ' in file ' . $e->getFile()], 500);
        }
    }
}
