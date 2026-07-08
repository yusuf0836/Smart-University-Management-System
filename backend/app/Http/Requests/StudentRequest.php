<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentRequest extends FormRequest
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
        $studentId = $this->route('student');

        return [
            'department_id' => ['required', 'exists:departments,id'],
            'semester_id'   => ['required', 'exists:semesters,id'],

            'name'          => ['required', 'string', 'max:255'],

            'student_id'    => [
                'required',
                'string',
                'max:255',
                Rule::unique('students')->ignore($studentId),
            ],

            'email'         => [
                'required',
                'email',
                Rule::unique('students')->ignore($studentId),
            ],

            'phone'         => ['nullable', 'string', 'max:20'],

            'gender'        => [
                'required',
                Rule::in(['Male', 'Female', 'Other']),
            ],

            'date_of_birth' => ['required', 'date'],

            'admission_date' => ['required', 'date'],

            'status' => ['required', 'boolean'],
        ];
    }
}