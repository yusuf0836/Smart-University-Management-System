<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExaminationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'academic_session' => $this->academicSession,

            'department' => $this->department,

            'semester' => $this->semester,

            'course' => $this->course,

            'exam_name' => $this->exam_name,

            'exam_type' => $this->exam_type,

            'exam_date' => $this->exam_date,

            'start_time' => $this->start_time,

            'end_time' => $this->end_time,

            'venue' => $this->venue,

            'total_marks' => $this->total_marks,

            'pass_marks' => $this->pass_marks,

            'status' => $this->status,

            'remarks' => $this->remarks,

            'created_at' => $this->created_at,

            'updated_at' => $this->updated_at,
        ];
    }
}