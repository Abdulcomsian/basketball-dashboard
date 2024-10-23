<?php

namespace App\Services;

use App\Http\Resources\VideoWatchActivityResource;
use App\Models\VideoWatchActivity;
use Illuminate\Support\Facades\DB;

class VideoWatchActivityService
{
    public function store($data)
    {
        validator($data, [
            'user_id' => 'required|exists:users,id',
            'video_id' => 'required|exists:videos,id',
            'watched_time' => 'required|integer',
        ])->validate();

        return VideoWatchActivity::updateOrCreate(
            [
                'user_id' => $data['user_id'],
                'video_id' => $data['video_id'],
            ],
            [
                'watched_time' => DB::raw('watched_time + ' . $data['watched_time']),
                'watched_at' => now(),
            ]
        );
    }

    public function getWatchedToday($userId)
    {
        $records = VideoWatchActivity::where('user_id', $userId)
            ->whereDate('watched_at', now()->startOfDay())
            ->get();

        if ($records->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No watched videos found for today.',
                'data' => [],
            ], 404);
        }

        $totalWatchTimeToday = $records->sum(function ($record) {
            return (int)$record->watched_time;
        });

        return VideoWatchActivityResource::collection($records)->additional([
            'status' => 200,
            'message' => 'Videos Found Successfully',
            'totalWatchTimeToday' => $totalWatchTimeToday . ' sec'
        ]);
    }

    public function getWatchedLast7Days($userId)
    {
        $records = VideoWatchActivity::where('user_id', $userId)
            ->where('watched_at', '>=', now()->subDays(7))
            ->get();

            if ($records->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No watched videos found in the last 7 days.',
                    'data' => [],
                ], 404);
            }

            $totalWatchTimeForWeek = $records->sum(function ($record) {
                return (int)$record->watched_time;
            });

        return VideoWatchActivityResource::collection($records)->additional([
            'status' => 200,
            'message' => 'Videos Found Successfully',
            'totalWatchTimeForWeek' => $totalWatchTimeForWeek . ' sec'
        ]);
    }

    public function getWatchedLastMonth($userId)
    {
        $records = VideoWatchActivity::where('user_id', $userId)
            ->where('watched_at', '>=', now()->subMonth())
            ->get();

            if ($records->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No watched videos found in the last month.',
                    'data' => [],
                ], 404);
            }

            $totalWatchTimeForMonth = $records->sum(function ($record) {
                return (int)$record->watched_time;
            });

        return VideoWatchActivityResource::collection($records)->additional([
            'status' => 200,
            'message' => 'Videos Found Successfully',
            'totalWatchTimeForMonth' => $totalWatchTimeForMonth . ' sec'
        ]);
    }

    public function getWatchedLifetime($userId)
    {
        $records = VideoWatchActivity::where('user_id', $userId)->get();

        if ($records->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No watched videos found.',
                'data' => [],
            ], 404);
        }

        $totalWatchTime = $records->sum(function ($record) {
            return (int)$record->watched_time;
        });

        return VideoWatchActivityResource::collection($records)->additional([
            'status' => 200,
            'message' => 'Videos Found Successfully',
            'totalWatchTime' => $totalWatchTime . ' sec'
        ]);
    }
}
