<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTeacherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'faculty_id' => [
                'nullable',
                'exists:faculties,id',
            ],

            'department_id' => [
                'required',
                'exists:departments,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'employee_id' => [
                'required',
                'string',
                'max:50',
                'unique:teachers,employee_id',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:teachers,email',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:20',
            ],

            'gender' => [
                'nullable',
                Rule::in([
                    'Male',
                    'Female',
                    'Other',
                ]),
            ],

            'designation' => [
                'required',
                'string',
                'max:100',
            ],

            'qualification' => [
                'nullable',
                'string',
                'max:255',
            ],

            'joining_date' => [
                'required',
                'date',
            ],

            'salary' => [
                'required',
                'numeric',
                'min:0',
            ],

            'blood_group' => [
                'nullable',
                'string',
                'max:5',
            ],

            'address' => [
                'nullable',
                'string',
            ],

            'photo' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',
                'boolean',
            ],
        ];
    }
}