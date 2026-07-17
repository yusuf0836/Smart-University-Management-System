<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFacultyRequest extends FormRequest
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
                'unique:faculties,name',
            ],

            'code' => [
                'required',
                'string',
                'max:20',
                'unique:faculties,code',
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

            'status.boolean' => 'Status must be true or false.',

        ];
    }
}