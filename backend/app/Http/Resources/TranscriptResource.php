<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TranscriptResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [

            'student' => new StudentResource($this['student']),

            'semester' => new SemesterResource($this['semester']),

            'results' => ResultResource::collection($this['results']),

            'summary' => [

                'semester_gpa' => $this['semester_gpa'],

                'cgpa' => $this['cgpa'],

                'total_credit_completed' => $this['total_credit_completed'],

                'total_courses' => $this['total_courses'],

            ],

            'generated_at' => now()->format('Y-m-d H:i:s'),
        ];
    }
}