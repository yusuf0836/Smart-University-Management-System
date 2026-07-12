<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResultResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'enrollment' => new EnrollmentResource(
                $this->whenLoaded('enrollment')
            ),

            'marks' => $this->marks,

            'grade' => $this->grade,

            'grade_point' => $this->grade_point,

            'remarks' => $this->remarks,

            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),

            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}