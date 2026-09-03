<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherReportResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'teacher_id' => $this->teacher_id,

            'name' => $this->name,

            'email' => $this->email,

            'phone' => $this->phone,

            'status' => $this->status,

            'department' => $this->whenLoaded(
                'department',
                function () {
                    return [
                        'id' => $this->department->id,

                        'name' => $this->department->name ?? null,
                    ];
                }
            ),

            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),

        ];
    }
}