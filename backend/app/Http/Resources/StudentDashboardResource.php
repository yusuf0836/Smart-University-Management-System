<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentDashboardResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'student' => new StudentResource(
                $this['student']
            ),

            'current_semester' => $this['current_semester'],

            'enrolled_courses' => EnrollmentResource::collection(
                $this['enrolled_courses']
            ),

            'today' => [

                'routine' => RoutineResource::collection(
                    $this['today']['routine']
                ),

                'total_classes' => $this['today']['total_classes'],

            ],

            'attendance_summary' => $this['attendance_summary'],

            'cgpa' => $this['cgpa'],

            'latest_result' => ResultResource::collection(
                $this['latest_result']
            ),

            'upcoming_examinations' => ExaminationResource::collection(
                $this['upcoming_examinations']
            ),

        ];
    }
}