<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherCourseAssignmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'teacher' => [
                'id' => $this->teacher->id,
                'name' => $this->teacher->name,
                'employee_id' => $this->teacher->employee_id,
            ],

            'course' => [
                'id' => $this->course->id,
                'course_code' => $this->course->course_code,
                'course_title' => $this->course->course_title,
            ],

            'semester' => [
                'id' => $this->semester->id,
                'name' => $this->semester->name,
            ],

            'academic_session' => [
                'id' => $this->academicSession->id,
                'name' => $this->academicSession->name,
            ],

            'section' => $this->section,

            'assigned_date' => optional($this->assigned_date)
                ->format('Y-m-d'),

            'status' => $this->status,

            'remarks' => $this->remarks,

            'created_at' => optional($this->created_at)
                ->format('Y-m-d H:i:s'),

            'updated_at' => optional($this->updated_at)
                ->format('Y-m-d H:i:s'),
        ];
    }
}