<?php

namespace App\Services;

use App\Models\Video;
use Illuminate\Http\Request;
use App\Http\Resources\VideoResource;

class VideoService
{
    public function allVideos(Request $request)
    {
        $request->validate([
            'length_id' => 'required|integer',
            'level_id' => 'required|array',
            'level_id.*' => 'integer',
            'skill_id' => 'required|array',
            'skill_id.*' => 'integer',
        ]);

        $videos = Video::where('workout_length_id', $request->length_id)
            ->where(function ($query) use ($request) {
                foreach ($request->level_id as $levelId) {
                    $query->orWhere('difficulty_level_ids', 'LIKE', '%"' . $levelId . '"%');
                }
            })
            ->where(function ($query) use ($request) {
                foreach ($request->skill_id as $skillId) {
                    $query->orWhere('skill_ids', 'LIKE', '%"' . $skillId . '"%');
                }
            })
            ->select('id', 'path', 'workout_length_id', 'difficulty_level_ids', 'skill_ids')
            ->get();

        $totalWorkoutTime = $videos->sum(function ($video) {
            return (int)$video->workout->name;
        });

        return VideoResource::collection($videos)->additional([
            'status' => 200,
            'message' => 'Videos Found Successfully',
            'totalWorkoutTime' => $totalWorkoutTime . ' minutes',
        ]);
    }

    public function getSingleVideo($id)
    {
        try {
            $video = Video::with('workout')->find($id);

            if (!$video) {
                return response()->json([
                    'status' => 422,
                    'message' => 'Video Not Found'
                ], 422);
            }

            return (new VideoResource($video))->additional([
                'status' => 200,
                'message' => 'Video Found Successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage() . ' on line ' . $e->getLine() . ' in file ' . $e->getFile()
            ], 500);
        }
    }
}
