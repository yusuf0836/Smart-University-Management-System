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

            'enrollment' => $this->enrollment,

            'student' => $this->student,

            'semester' => $this->semester,

            'academic_session' => $this->academicSession,

            'total_credit' => $this->total_credit,

            'earned_credit' => $this->earned_credit,

            'total_grade_point' => $this->total_grade_point,

            'gpa' => $this->gpa,

            'result_status' => $this->result_status,

            'remarks' => $this->remarks,

            'status' => $this->status,

            'created_at' => $this->created_at,

            'updated_at' => $this->updated_at,

        ];
    }
}