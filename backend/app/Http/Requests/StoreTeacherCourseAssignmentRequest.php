<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTeacherCourseAssignmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'teacher_id' => [
                'required',
                'exists:teachers,id',
            ],

            'course_id' => [
                'required',
                'exists:courses,id',
            ],

            'semester_id' => [
                'required',
                'exists:semesters,id',
            ],

            'academic_session_id' => [
                'required',
                'exists:academic_sessions,id',
            ],

            'section' => [
                'required',
                'string',
                'max:20',
            ],

            'assigned_date' => [
                'required',
                'date',
            ],

            'status' => [
                'required',
                'boolean',
            ],

            'remarks' => [
                'nullable',
                'string',
            ],
        ];
    }
}