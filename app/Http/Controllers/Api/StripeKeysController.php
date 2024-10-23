<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StripeKey;
use Exception;
use Illuminate\Http\Request;

class StripeKeysController extends Controller
{
    public function index()
    {
        try {
            $keys = StripeKey::all();
            return response()->json([
                'status' => 'success',
                'data'=> $keys
            ], 200);
        } catch(Exception $e) {
            return response()->json(['message' => $e->getMessage().' on line '.$e->getLine().' in file '.$e->getFile()], 500);
        }
    }
}
