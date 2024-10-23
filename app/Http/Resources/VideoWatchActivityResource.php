<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VideoWatchActivityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
            ],
            'video' => [
                'id' => $this->video->id,
                'path' => url($this->video->path),
                'workout' => [
                    'id' => $this->video->workout->id,
                    'name' => $this->video->workout->name,
                ],
                'levels' => $this->video->levels(),
                'skills' => $this->video->skills(),
            ],
            'watched_time' => $this->watched_time . ' sec',
            'watched_at' => $this->watched_at
        ];
    }
}
