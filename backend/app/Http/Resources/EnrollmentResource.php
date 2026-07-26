<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EnrollmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'student' => [
                'id' => $this->student->id,
                'student_id' => $this->student->student_id,
                'name' => $this->student->name,
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

            'enrollment_date' => optional($this->enrollment_date)
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