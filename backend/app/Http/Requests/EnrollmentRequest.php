<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EnrollmentRequest extends FormRequest
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
        $enrollment = $this->route('enrollment');

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

            Rule::unique('enrollments')
                ->ignore($enrollment)
                ->where(function ($query) {
                    return $query
                        ->where('student_id', $this->student_id)
                        ->where('course_id', $this->course_id)
                        ->where('semester_id', $this->semester_id);
                }),
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'student_id.required' => 'Student is required.',
            'student_id.exists' => 'Selected student does not exist.',

            'course_id.required' => 'Course is required.',
            'course_id.exists' => 'Selected course does not exist.',

            'semester_id.required' => 'Semester is required.',
            'semester_id.exists' => 'Selected semester does not exist.',

            'enrollment_date.required' => 'Enrollment date is required.',
            'enrollment_date.date' => 'Enrollment date must be a valid date.',

            'status.required' => 'Status is required.',

            'unique' => 'This student is already enrolled in this course for the selected semester.',
        ];
    }
}