<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSemesterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation Rules
     */
    public function rules(): array
    {
        return [

            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('semesters', 'name')
                    ->ignore($this->semester),
            ],

            'start_date' => [
                'required',
                'date',
            ],

            'end_date' => [
                'required',
                'date',
                'after:start_date',
            ],

            'status' => [
                'required',
                'boolean',
            ],

        ];
    }

    /**
     * Custom Messages
     */
    public function messages(): array
    {
        return [

            'name.required' => 'Semester name is required.',
            'name.unique' => 'Semester already exists.',

            'start_date.required' => 'Start date is required.',
            'start_date.date' => 'Start date must be a valid date.',

            'end_date.required' => 'End date is required.',
            'end_date.after' => 'End date must be after start date.',

            'status.required' => 'Status is required.',
            'status.boolean' => 'Status must be true or false.',

        ];
    }
}