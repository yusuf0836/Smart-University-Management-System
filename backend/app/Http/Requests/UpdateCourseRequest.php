<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'department_id' => [
                'required',
                'exists:departments,id',
            ],

            'semester_id' => [
                'required',
                'exists:semesters,id',
            ],

            'course_code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('courses', 'course_code')
                    ->ignore($this->course),
            ],

            'course_title' => [
                'required',
                'string',
                'max:255',
            ],

            'credit' => [
                'required',
                'numeric',
                'between:0.5,10',
            ],

            'type' => [
                'required',
                Rule::in([
                    'Theory',
                    'Lab',
                ]),
            ],

            'status' => [
                'required',
                'boolean',
            ],
        ];
    }
}