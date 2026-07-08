<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SemesterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $semester = $this->route('semester');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('semesters')->ignore($semester),
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
}