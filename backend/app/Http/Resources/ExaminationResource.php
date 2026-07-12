<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExaminationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'department' => new DepartmentResource(
                $this->whenLoaded('department')
            ),

            'semester' => new SemesterResource(
                $this->whenLoaded('semester')
            ),

            'exam_name' => $this->exam_name,

            'exam_type' => $this->exam_type,

            'exam_date' => $this->exam_date?->format('Y-m-d'),

            'start_time' => $this->start_time,

            'end_time' => $this->end_time,

            'venue' => $this->venue,

            'status' => $this->status,

            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),

            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}