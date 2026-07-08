<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeacherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $teacherId = $this->route('teacher');

        return [
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:255',

            'employee_id' => 'required|string|max:255|unique:teachers,employee_id,' . $teacherId,

            'email' => 'required|email|unique:teachers,email,' . $teacherId,

            'phone' => 'nullable|string|max:20',

            'designation' => 'required|string|max:255',

            'joining_date' => 'required|date',

            'salary' => 'required|numeric',

            'status' => 'boolean',
        ];
    }
}