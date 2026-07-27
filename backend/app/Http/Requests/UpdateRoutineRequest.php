<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoutineRequest extends FormRequest
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
        return [

            'department_id' => [
                'required',
                'exists:departments,id'
            ],

            'semester_id' => [
                'required',
                'exists:semesters,id'
            ],

            'course_id' => [
                'required',
                'exists:courses,id'
            ],

            'teacher_id' => [
                'required',
                'exists:teachers,id'
            ],

            'day' => [
                'required',
                'in:Saturday,Sunday,Monday,Tuesday,Wednesday,Thursday,Friday'
            ],

            'start_time' => [
                'required',
                'date_format:H:i'
            ],

            'end_time' => [
                'required',
                'date_format:H:i',
                'after:start_time'
            ],

            'room_no' => [
                'required',
                'string',
                'max:50'
            ],

            'building' => [
                'nullable',
                'string',
                'max:255'
            ],

            'status' => [
                'nullable',
                'boolean'
            ],

            'remarks' => [
                'nullable',
                'string',
                'max:1000'
            ],
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [

            'department_id.required' => 'Department is required.',

            'semester_id.required' => 'Semester is required.',

            'course_id.required' => 'Course is required.',

            'teacher_id.required' => 'Teacher is required.',

            'day.required' => 'Day is required.',

            'day.in' => 'Invalid day selected.',

            'start_time.required' => 'Start time is required.',

            'end_time.required' => 'End time is required.',

            'end_time.after' => 'End time must be greater than start time.',

            'room_no.required' => 'Room number is required.',
        ];
    }
}