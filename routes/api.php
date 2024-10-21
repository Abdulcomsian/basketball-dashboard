<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\WorkoutController;
use App\Http\Controllers\Api\LevelController;
use App\Http\Controllers\Api\SkillController;
use App\Http\Controllers\Api\VideoController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function() {

    Route::get('/user', [AuthController::class, 'getUser']);
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
    Route::get('get/videos', [VideoController::class, 'allVideos']);
    Route::get('get/single/video/{id}', [VideoController::class, 'getSingleVideo']);
});
