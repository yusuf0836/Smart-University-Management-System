<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Student;

class CGPAResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'student' => new StudentResource(
                $this['student']
            ),

            'student_id' => $this['student_id'],

            'total_semester' => $this['total_semester'],

            'total_credit' => $this['total_credit'],

            'earned_credit' => $this['earned_credit'],

            'total_grade_point' => $this['total_grade_point'],

            'cgpa' => $this['cgpa'],

            'result_status' => $this['result_status'],

            'semester_results' => ResultResource::collection(
                $this['results']
            ),

        ];
    }
}