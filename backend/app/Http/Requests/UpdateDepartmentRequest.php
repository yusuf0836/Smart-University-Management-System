<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'faculty_id' => [
                'required',
                'exists:faculties,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('departments', 'name')
                    ->ignore($this->department),
            ],

            'code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('departments', 'code')
                    ->ignore($this->department),
            ],

            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'status' => [
                'required',
                'boolean',
            ],

        ];
    }
}