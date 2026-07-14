<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TranscriptResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'student' => new StudentResource(
                $this->whenLoaded('student')
            ),

            'semester' => new SemesterResource(
                $this->whenLoaded('semester')
            ),

            'semester_gpa' => $this->semester_gpa,

            'cgpa' => $this->cgpa,

            'total_credits' => $this->total_credits,

            'status' => $this->status,

            'created_at' => $this->created_at,

            'updated_at' => $this->updated_at,

        ];
    }
}