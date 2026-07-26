<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStudentRequest extends FormRequest
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

            'academic_session_id' => [
                'required',
                'exists:academic_sessions,id',
            ],

            'student_id' => [
                'required',
                'string',
                'max:30',
                'unique:students,student_id',
            ],

            'name' => [
                'required',
                'string',
                'max:150',
            ],

            'email' => [
                'required',
                'email',
                'max:100',
                'unique:students,email',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:20',
            ],

            'gender' => [
                'required',
                Rule::in([
                    'Male',
                    'Female',
                    'Other',
                ]),
            ],

            'date_of_birth' => [
                'required',
                'date',
            ],

            'admission_date' => [
                'required',
                'date',
            ],

            'blood_group' => [
                'nullable',
                Rule::in([
                    'A+',
                    'A-',
                    'B+',
                    'B-',
                    'AB+',
                    'AB-',
                    'O+',
                    'O-',
                ]),
            ],

            'guardian_name' => [
                'nullable',
                'string',
                'max:150',
            ],

            'guardian_phone' => [
                'nullable',
                'string',
                'max:20',
            ],

            'address' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'photo' => [
                'nullable',
                'string',
                'max:255',
            ],

            'status' => [
                'required',
                'boolean',
            ],
        ];
    }
}