<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoutineResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'course' => new CourseResource($this->whenLoaded('course')),

            'teacher' => new TeacherResource($this->whenLoaded('teacher')),

            'semester' => new SemesterResource($this->whenLoaded('semester')),

            'day' => $this->day,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'room' => $this->room,
            'status' => $this->status,

            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}