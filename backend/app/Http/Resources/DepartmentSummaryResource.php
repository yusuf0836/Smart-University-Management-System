<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentSummaryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'name' => $this->name,

            'code' => $this->code ?? null,

            'status' => $this->status,

            'total_students' => $this->when(
                isset($this->students_count),
                $this->students_count
            ),

            'total_teachers' => $this->when(
                isset($this->teachers_count),
                $this->teachers_count
            ),

            'total_courses' => $this->when(
                isset($this->courses_count),
                $this->courses_count
            ),

            'created_at' => $this->created_at?->format(
                'Y-m-d H:i:s'
            ),

        ];
    }
}