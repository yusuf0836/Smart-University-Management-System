<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MarkResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'student' => $this->student,

            'examination' => $this->examination,

            'marks_obtained' => $this->marks_obtained,

            'grade' => $this->grade,

            'grade_point' => $this->grade_point,

            'remarks' => $this->remarks,

            'status' => $this->status,

            'created_at' => $this->created_at,

            'updated_at' => $this->updated_at,
        ];
    }
}