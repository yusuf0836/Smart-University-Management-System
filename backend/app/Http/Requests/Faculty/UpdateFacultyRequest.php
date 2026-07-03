<?php

namespace App\Http\Requests\Faculty;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFacultyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',

            'code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('faculties', 'code')->ignore($this->route('faculty')),
            ],

            'description' => 'nullable|string',

            'status' => 'required|boolean',
        ];
    }
}