<?php

namespace App\Http\Controllers\Admin;

use App\Models\Skill;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SkillsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $skills = Skill::all();
        return view('admin.skills.index', ['skills' => $skills]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.skills.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'file' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        $skill = new Skill;
        $skill->name = $request->name;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $directory = public_path('uploads/skills');

            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

            $filePath = $file->store('skills', 'public');
            $skill->file = $filePath;
        }

        $skill->save();

        return redirect()->route('admin.skills.index')->with('success', 'Skill Created Successfully');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $skill = Skill::find($id);
        return view('admin.skills.edit', ['skill' => $skill]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $skill = Skill::find($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        $skill->name = $request->name;

        if ($request->hasFile('file')) {
            if ($skill->file) {
                $oldFilePath = public_path('storage/' . $skill->file);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            $directory = public_path('uploads/skills');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

            $file = $request->file('file');
            $filePath = $file->store('skills', 'public');
            $skill->file = $filePath;
        }

        $skill->save();

        return redirect()->route('admin.skills.index')->with('success', 'Skill Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $skill = Skill::find($id);
        $skill->delete();

        return redirect()->route('admin.skills.index')->with('success', 'Skill Deleted Successfully');
    }
}
