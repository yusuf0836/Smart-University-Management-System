<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'department' => $this->department?->name,

            'semester' => $this->semester?->name,

            'academic_session' => $this->academicSession?->name,

            'student_id' => $this->student_id,

            'name' => $this->name,

            'email' => $this->email,

            'phone' => $this->phone,

            'gender' => $this->gender,

            'date_of_birth' => optional($this->date_of_birth)->format('Y-m-d'),

            'admission_date' => optional($this->admission_date)->format('Y-m-d'),

            'blood_group' => $this->blood_group,

            'guardian_name' => $this->guardian_name,

            'guardian_phone' => $this->guardian_phone,

            'address' => $this->address,

            'photo' => $this->photo,

            'status' => $this->status,

            'created_at' => optional($this->created_at)->format('Y-m-d H:i:s'),

            'updated_at' => optional($this->updated_at)->format('Y-m-d H:i:s'),
        ];
    }
}