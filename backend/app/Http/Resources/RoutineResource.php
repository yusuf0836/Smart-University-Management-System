<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoutineResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'department' => $this->department,

            'semester' => $this->semester,

            'course' => $this->course,

            'teacher' => $this->teacher,

            'day' => $this->day,

            'start_time' => $this->start_time,

            'end_time' => $this->end_time,

            'room_no' => $this->room_no,

            'building' => $this->building,

            'status' => $this->status,

            'remarks' => $this->remarks,

            'created_at' => $this->created_at,

            'updated_at' => $this->updated_at,
        ];
    }
}