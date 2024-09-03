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
}
