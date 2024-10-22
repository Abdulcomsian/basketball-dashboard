<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\VideoService;
use App\Http\Controllers\Controller;

class VideoController extends Controller
{
    protected $videoService;

    public function __construct(VideoService $videoService)
    {
        $this->videoService = $videoService;
    }
    public function allVideos(Request $request)
    {
        try {
            return $this->videoService->allVideos($request);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage() . ' on line ' . $e->getLine() . ' in file ' . $e->getFile()
            ], 500);
        }
    }

    public function getSingleVideo($id)
    {
        try {
            return $this->videoService->getSingleVideo($id);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage() . ' on line ' . $e->getLine() . ' in file ' . $e->getFile()
            ], 500);
        }
    }
}
