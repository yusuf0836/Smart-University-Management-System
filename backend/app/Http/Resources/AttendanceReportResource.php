<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'attendance_date' => optional(
                $this->attendance_date
            )->format('Y-m-d'),

            'status' => $this->status,

            'remarks' => $this->remarks,

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

            'teacher' => $this->whenLoaded(
                'teacher',
                function () {

                    return [

                        'id' => $this->teacher->id,

                        'name' => $this->teacher->name,

                    ];

                }
            ),

            'course' => $this->whenLoaded(
                'course',
                function () {

                    return [

                        'id' => $this->course->id,

                        'course_code' => $this->course->course_code,

                        'course_title' => $this->course->course_title,

                    ];

                }
            ),

            'semester' => $this->whenLoaded(
                'semester',
                function () {

                    return [

                        'id' => $this->semester->id,

                        'name' => $this->semester->name,

                    ];

                }
            ),

            'created_at' => optional(
                $this->created_at
            )->format('Y-m-d H:i:s'),

        ];
    }
}