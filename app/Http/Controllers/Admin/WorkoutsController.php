<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\WorkoutLength;
use App\Http\Controllers\Controller;

class WorkoutsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $workouts = WorkoutLength::all();
        return view('admin.workouts.index', ['workouts' => $workouts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.workouts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $workout = new WorkoutLength;
        $workout->name = $request->name;
        $workout->save();

        return redirect()->route('admin.workouts.index')->with('success', 'Workout Length Created Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $workout = WorkoutLength::find($id);
        return view('admin.workouts.edit', ['workout' => $workout]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $workout = WorkoutLength::find($id);
        $workout->name = $request->name;
        $workout->save();

        return redirect()->route('admin.workouts.index')->with('success', 'Workout Length Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $workout = WorkoutLength::find($id);
        $workout->delete();

        return redirect()->route('admin.workouts.index')->with('success', 'Workout Length Deleted Successfully');
    }
}
