<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentReportResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'student_id' => $this->student_id,

            'name' => $this->name,

            'email' => $this->email,

            'phone' => $this->phone,

            'status' => $this->status,

            'department' => $this->whenLoaded(
                'department',
                function () {
                    return [
                        'id' => $this->department->id,
                        'name' => $this->department->name,
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