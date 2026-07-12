<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'student' => new StudentResource(
                $this->whenLoaded('student')
            ),

            'course' => new CourseResource(
                $this->whenLoaded('course')
            ),

            'semester' => new SemesterResource(
                $this->whenLoaded('semester')
            ),

            'attendance_date' => $this->attendance_date?->format('Y-m-d'),

            'status' => $this->status,

            'remarks' => $this->remarks,

            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),

            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}