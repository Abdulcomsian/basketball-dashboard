<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\DifficultyLevel;
use App\Http\Controllers\Controller;

class LevelsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $levels = DifficultyLevel::all();
        return view('admin.levels.index', ['levels' => $levels]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.levels.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $level = new DifficultyLevel;
        $level->name = $request->name;
        $level->save();

        return redirect()->route('admin.levels.index')->with('success', 'Difficulty Level Created Successfully');
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
        $level = DifficultyLevel::find($id);
        return view('admin.levels.edit', ['level' => $level]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $level = DifficultyLevel::find($id);
        $level->name = $request->name;
        $level->save();

        return redirect()->route('admin.levels.index')->with('success', 'Difficulty Level Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $level = DifficultyLevel::find($id);
        $level->delete();

        return redirect()->route('admin.levels.index')->with('success', 'Difficulty Level Deleted Successfully');
    }
}
