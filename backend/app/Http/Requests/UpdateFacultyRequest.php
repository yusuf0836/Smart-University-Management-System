<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFacultyRequest extends FormRequest
{
    /**
     * Authorize request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules.
     */
    public function rules(): array
    {
        return [

            'name' => [

                'required',

                'string',

                'max:255',

                Rule::unique('faculties', 'name')
                    ->ignore($this->faculty),

            ],

            'code' => [

                'required',

                'string',

                'max:20',

                Rule::unique('faculties', 'code')
                    ->ignore($this->faculty),

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

    /**
     * Custom messages.
     */
    public function messages(): array
    {
        return [

            'name.required' => 'Faculty name is required.',

            'name.unique' => 'Faculty name already exists.',

            'code.required' => 'Faculty code is required.',

            'code.unique' => 'Faculty code already exists.',

            'status.required' => 'Status is required.',

        ];
    }
}