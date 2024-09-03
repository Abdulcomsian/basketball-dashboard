<?php

namespace App\Http\Controllers\Admin;

use App\Models\Skill;
use App\Models\Video;
use Illuminate\Http\Request;
use App\Models\WorkoutLength;
use App\Models\DifficultyLevel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class UploadVideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = Video::with('workout')->get();
        return view('admin.videos.index', ['videos' => $videos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $levels = DifficultyLevel::all();
        $skills = Skill::all();
        $workouts = WorkoutLength::all();
        return view('admin.videos.create', [
            'levels' => $levels,
            'skills' => $skills,
            'workouts' => $workouts
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'video' => 'required|mimes:mp4,avi,mkv|max:100000',
        ]);

        $video = new Video;
        $video->workout_length_id = $request->workout;
        $video->difficulty_level_ids = json_encode($request->levels);
        $video->skill_ids = json_encode($request->skills);
        $video->save();

        //Handle Video
        if($request->hasFile('video')) {

            $file = $request->file('video');
            $file_name = $file->getClientOriginalName();
            $file_name = time() . '_' . $file_name;
            $path = $file->storeAs('public/videos', $file_name);

            //Store Path
            $video->path = Storage::url($path);
            $video->save();
        }

        return redirect()->route('admin.videos.index')->with('success', 'Video Uploaded Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $video = Video::where('id', $id)->with('workout')->first();
        $levels = DifficultyLevel::all();
        $skills = Skill::all();
        $workouts = WorkoutLength::all();
        return view('admin.videos.edit', [
            'video' => $video,
            'levels' => $levels,
            'skills' => $skills,
            'workouts' => $workouts
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'video' => 'nullable|mimes:mp4,avi,mkv|max:100000',
        ]);

        //Update Record
        $video = Video::find($id);
        $video->workout_length_id = $request->workout;
        $video->difficulty_level_ids = $request->levels;
        $video->skill_ids = $request->skills;
        $video->save();

        //Handle Video
        if($request->hasFile('video')) {

            //Remove Old Video
            if(!is_null($video->path)) {
                $oldPath = str_replace('/storage', 'public', $video->path);
                Storage::delete($oldPath);
            }

            //Store New Video
            $file = $request->file('video');
            $file_name = $file->getClientOriginalName();
            $file_name = time() . '_' . $file_name;
            $path = $file->storeAs('public/videos', $file_name);

            //Store Path
            $video->path = Storage::url($path);
            $video->save();
        }

        return redirect()->route('admin.videos.index')->with('success', 'Video Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $video = Video::find($id);
        //Remove Video
        if(!is_null($video->path)) {
            $oldPath = str_replace('/storage', 'public', $video->path);
            Storage::delete($oldPath);
        }
        //Delete Video
        $video->delete();

        return redirect()->route('admin.videos.index')->with('success', 'Video Deleted Successfully');
    }
}
