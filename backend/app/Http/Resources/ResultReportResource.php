<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResultReportResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'student' => $this->whenLoaded(
                'student',
                function () {
                    return [
                        'id' => $this->student->id,

                        'student_id' => $this->student->student_id,

                        'name' => $this->student->name,
                    ];
                }
            ),

            'semester' => $this->whenLoaded(
                'semester',
                function () {
                    return [
                        'id' => $this->semester->id,

                        'name' => $this->semester->name ?? null,
                    ];
                }
            ),

            'academic_session' => $this->whenLoaded(
                'academicSession',
                function () {
                    return [
                        'id' => $this->academicSession->id,

                        'name' => $this->academicSession->name ?? null,
                    ];
                }
            ),

            'total_credit' => $this->total_credit,

            'earned_credit' => $this->earned_credit,

            'total_grade_point' => $this->total_grade_point,

            'gpa' => $this->gpa,

            'result_status' => $this->result_status,

            'remarks' => $this->remarks,

            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),

        ];
    }
}