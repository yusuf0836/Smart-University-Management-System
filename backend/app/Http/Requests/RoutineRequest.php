<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoutineRequest extends FormRequest
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
            'department_id' => 'required|exists:departments,id',
            'semester_id'   => 'required|exists:semesters,id',
            'course_id'     => 'required|exists:courses,id',
            'teacher_id'    => 'required|exists:teachers,id',

            'day' => 'required|in:Saturday,Sunday,Monday,Tuesday,Wednesday,Thursday,Friday',

            'start_time' => 'required|date_format:H:i',

            'end_time' => 'required|date_format:H:i|after:start_time',

            'room_no' => 'required|string|max:50',

            'status' => 'required|boolean',
        ];
    }
}