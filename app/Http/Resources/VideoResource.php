<?php

namespace App\Http\Resources;

use App\Models\Skill;
use App\Models\DifficultyLevel;
use Illuminate\Http\Resources\Json\JsonResource;

class VideoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'path' => url($this->path),
            'workout_length' => $this->workout ? [
                'id' => $this->workout->id,
                'time' => $this->workout->name . ' minutes ',
            ] : null,
            'levels' => $this->levels(),
            'skills' => $this->skills(),
        ];
    }
}
