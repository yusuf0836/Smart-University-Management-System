<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEnrollmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'student_id' => [
                'required',
                'exists:students,id',
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

            'enrollment_date' => [
                'required',
                'date',
            ],

            'status' => [
                'required',
                Rule::in([
                    'Enrolled',
                    'Dropped',
                    'Completed',
                ]),
            ],

            'remarks' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ];
    }
}