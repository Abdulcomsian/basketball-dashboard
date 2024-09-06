<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Video;

class VideoController extends Controller
{
    public function allVideos()
    {
        try {
            $videos = Video::with('workout')->get();

            return response()->json([
                'status' => 200,
                'message' => 'Videos Found Successfully',
                'data' => $videos
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage().' on line '.$e->getLine().' in file '.$e->getFile()], 500);
        }
    }

    public function getSingleVideo($id)
    {
        try {

            $video = Video::where('id', $id)->with('workout')->first();
            if(!$video) {
                return response()->json([
                    'status' => 422,
                    'message' => 'Video Not Found'
                ], 422);
            }
            
            return response()->json([
                'status' => 200,
                'message' => 'Video Found Successfully',
                'data' => $video
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage().' on line '.$e->getLine().' in file '.$e->getFile()], 500);
        }
    }
}