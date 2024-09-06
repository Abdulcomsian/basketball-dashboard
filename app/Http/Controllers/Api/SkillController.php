<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Skill;

class SkillController extends Controller
{
    public function allSkills()
    {
        try {

            $skills = Skill::all();

            return response()->json([
                'status' => 200,
                'message' => 'Skills Found Successfully',
                'data' => $skills
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage().' on line '.$e->getLine().' in file '.$e->getFile()], 500);
        }
    }

    public function getSingleSkill($id)
    {
        try {

            $skill = Skill::find($id);
            if(!$skill) {
                return response()->json([
                    'status' => 422,
                    'message' => 'Skill Not Found'
                ], 422);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Skill Found Successfully',
                'data' => $skill
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage().' on line '.$e->getLine().' in file '.$e->getFile()], 500);
        }
    }
}