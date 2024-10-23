<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use App\Services\VideoWatchActivityService;

class VideoWatchActivityController extends Controller
{
    protected $videoWatchActivityService;

    public function __construct(VideoWatchActivityService $videoWatchActivityService)
    {
        $this->videoWatchActivityService = $videoWatchActivityService;
    }

    public function store(Request $request)
    {
        try {
            $activity = $this->videoWatchActivityService->store($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Watch activity recorded successfully.',
                'activity' => $activity,
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error: ' . $e->getMessage(),
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function watchedToday($userId)
    {
        try {
            return $this->videoWatchActivityService->getWatchedToday($userId);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function watchedLast7Days($userId)
    {
        try {
            return $this->videoWatchActivityService->getWatchedLast7Days($userId);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function watchedLastMonth($userId)
    {
        try {
            return $this->videoWatchActivityService->getWatchedLastMonth($userId);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function watchedLifetime($userId)
    {
        try {
            return $this->videoWatchActivityService->getWatchedLifetime($userId);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }
}
