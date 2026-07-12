<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EnrollmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'student' => new StudentResource($this->whenLoaded('student')),

            'course' => new CourseResource($this->whenLoaded('course')),

            'semester' => new SemesterResource($this->whenLoaded('semester')),

            'enrollment_date' => $this->enrollment_date,

            'status' => $this->status,

            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}