<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAttendanceRequest extends FormRequest
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

            'routine_id' => [
                'nullable',
                'exists:routines,id',
            ],

            'attendance_date' => [
                'required',
                'date',
            ],

            'status' => [
                'required',
                'in:Present,Absent,Late,Leave',
            ],

            'remarks' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [

            'student_id.required' => 'Student is required.',

            'course_id.required' => 'Course is required.',

            'semester_id.required' => 'Semester is required.',

            'attendance_date.required' => 'Attendance date is required.',

            'status.required' => 'Attendance status is required.',

            'status.in' => 'Invalid attendance status.',
        ];
    }
}