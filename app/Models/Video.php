<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function workout()
    {
        return $this->belongsTo(WorkoutLength::class, 'workout_length_id', 'id');
    }

    public function levels()
    {
        $levelIds = json_decode($this->difficulty_level_ids, true);
        return DifficultyLevel::whereIn('id', $levelIds)->get()->map(function ($level) {
            return [
                'id' => $level->id,
                'name' => $level->name,
            ];
        });
    }

    public function skills()
    {
        $skillIds = json_decode($this->skill_ids, true);
        return Skill::whereIn('id', $skillIds)->get()->map(function ($skill) {
            $skillData = [
                'id' => $skill->id,
                'name' => $skill->name,
            ];

            if ($skill->file) {
                $skillData['file'] = url('storage/' . $skill->file);
            } else {
                $skillData['file'] = null;
            }

            return $skillData;
        });
    }
}
