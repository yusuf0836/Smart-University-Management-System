<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherCourseAssignmentReportResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

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
                        'course_code' => $this->course->course_code ?? null,
                        'course_title' => $this->course->course_title ?? null,
                    ];
                }
            ),

            'department' => $this->whenLoaded(
                'department',
                function () {
                    return [
                        'id' => $this->department->id,
                        'name' => $this->department->name ?? null,
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

            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),

        ];
    }
}