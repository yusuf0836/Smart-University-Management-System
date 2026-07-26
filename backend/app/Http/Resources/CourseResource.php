<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'department' => [
                'id' => $this->department?->id,
                'name' => $this->department?->name,
            ],

            'semester' => [
                'id' => $this->semester?->id,
                'name' => $this->semester?->name,
            ],

            'course_code' => $this->course_code,

            'course_title' => $this->course_title,

            'credit' => $this->credit,

            'type' => $this->type,

            'status' => $this->status,

            'created_at' => optional($this->created_at)
                ->format('Y-m-d H:i:s'),

            'updated_at' => optional($this->updated_at)
                ->format('Y-m-d H:i:s'),
        ];
    }
}