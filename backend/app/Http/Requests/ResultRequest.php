<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResultRequest extends FormRequest
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
            'enrollment_id' => [
                'required',
                'exists:enrollments,id',
                'unique:results,enrollment_id',
            ],

            'marks' => [
                'required',
                'numeric',
                'min:0',
                'max:100',
            ],

            'remarks' => [
                'nullable',
                'string',
                'max:500',
            ],
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'enrollment_id.required' => 'Enrollment is required.',
            'enrollment_id.exists' => 'Selected enrollment does not exist.',
            'enrollment_id.unique' => 'This enrollment already has a result.',

            'marks.required' => 'Marks is required.',
            'marks.numeric' => 'Marks must be numeric.',
            'marks.min' => 'Marks cannot be less than 0.',
            'marks.max' => 'Marks cannot be greater than 100.',

            'remarks.max' => 'Remarks may not be greater than 500 characters.',
        ];
    }
}