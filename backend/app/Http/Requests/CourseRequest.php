<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $course = $this->route('course');

        return [
            'department_id' => [
                'required',
                'exists:departments,id'
            ],

            'course_code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('courses')->ignore($course),
            ],

            'course_title' => [
                'required',
                'string',
                'max:255'
            ],

            'credit' => [
                'required',
                'numeric',
                'min:0.5',
                'max:6'
            ],

            'type' => [
                'required',
                Rule::in(['Theory', 'Lab']),
            ],

            'status' => [
                'required',
                'boolean'
            ],
        ];
    }
}