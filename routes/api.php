<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LevelController;
use App\Http\Controllers\Api\SkillController;
use App\Http\Controllers\Api\VideoController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\WorkoutController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\VideoWatchActivityController;
use App\Http\Controllers\Api\StripeKeysController as ApiStripeKeysController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    //Workout Length
    Route::get('get/workout-lengths', [WorkoutController::class, 'allWorkouts']);
    Route::get('get/single/workout-length/{id}', [WorkoutController::class, 'getSingleWorkout']);
    //Difficulty Level
    Route::get('get/difficulty-levels', [LevelController::class, 'allDifficultyLevels']);
    Route::get('get/single/difficulty-level/{id}', [LevelController::class, 'getSingleDifficultyLevel']);
    //Skills
    Route::get('get/skills', [SkillController::class, 'allSkills']);
    Route::get('get/single/skill/{id}', [SkillController::class, 'getSingleSkill']);
    //Videos
    Route::post('get/videos', [VideoController::class, 'allVideos']);
    Route::get('get/single/video/{id}', [VideoController::class, 'getSingleVideo']);

    Route::get('stripekeys', [ApiStripeKeysController::class, 'index']);

    Route::get('/profile', [ProfileController::class, 'getProfile']);
    Route::post('update-profile', [ProfileController::class, 'updateProfile']);

    Route::post('/video-watch', [VideoWatchActivityController::class, 'store']);

    Route::get('{userId}/watched/videos/today', [VideoWatchActivityController::class, 'watchedToday']);
    Route::get('{userId}/watched/videos/last-7-days', [VideoWatchActivityController::class, 'watchedLast7Days']);
    Route::get('{userId}/watched/videos/last-month', [VideoWatchActivityController::class, 'watchedLastMonth']);
    Route::get('{userId}/watched/videos/lifetime', [VideoWatchActivityController::class, 'watchedLifetime']);

    Route::post('/subscription/save', [SubscriptionController::class, 'saveSubscription']);
});
