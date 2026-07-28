<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreResultRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'enrollment_id' => [
                'required',
                'exists:enrollments,id',
            ],

            'student_id' => [
                'required',
                'exists:students,id',
            ],

            'semester_id' => [
                'required',
                'exists:semesters,id',
            ],

            'academic_session_id' => [
                'required',
                'exists:academic_sessions,id',
            ],

            'remarks' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'status' => [
                'nullable',
                'boolean',
            ],

        ];
    }
}