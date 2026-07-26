<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'faculty' => $this->faculty ? [
                'id' => $this->faculty->id,
                'name' => $this->faculty->name,
            ] : null,

            'department' => [
                'id' => $this->department->id,
                'name' => $this->department->name,
            ],

            'name' => $this->name,

            'employee_id' => $this->employee_id,

            'email' => $this->email,

            'phone' => $this->phone,

            'gender' => $this->gender,

            'designation' => $this->designation,

            'qualification' => $this->qualification,

            'joining_date' => optional($this->joining_date)
                ->format('Y-m-d'),

            'salary' => $this->salary,

            'blood_group' => $this->blood_group,

            'address' => $this->address,

            'photo' => $this->photo,

            'status' => $this->status,

            'created_at' => optional($this->created_at)
                ->format('Y-m-d H:i:s'),

            'updated_at' => optional($this->updated_at)
                ->format('Y-m-d H:i:s'),
        ];
    }
}