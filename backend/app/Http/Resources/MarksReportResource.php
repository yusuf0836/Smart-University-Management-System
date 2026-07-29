<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MarksReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'marks_obtained' => $this->marks_obtained,

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

                        'id' => $this->examination?->course->id,

                        'course_code' => $this->examination?->course->course_code,

                        'course_title' => $this->examination?->course->course_title,

                    ];

                }
            ),

            'semester' => $this->whenLoaded(
                'semester',
                function () {

                    return [

                        'id' => $this->examination?->semester->id,

                        'name' => $this->examination?->semester->name,

                    ];

                }
            ),

            'examination' => $this->whenLoaded(
                'examination',
                function () {

                    return [

                        'id' => $this->examination->id,

                        'exam_name' => $this->examination->exam_name,

                        'exam_type' => $this->examination->exam_type,

                    ];

                }
            ),

            'created_at' => optional(
                $this->created_at
            )->format('Y-m-d H:i:s'),

        ];
    }
}