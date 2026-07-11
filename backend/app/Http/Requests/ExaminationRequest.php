<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExaminationRequest extends FormRequest
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
            'department_id' => 'required|exists:departments,id',
            'semester_id'   => 'required|exists:semesters,id',

            'exam_name'     => 'required|string|max:255',

            'exam_type'     => 'required|in:Mid,Final,Quiz,Assignment,Practical,Viva,Improvement',

            'exam_date'     => 'required|date',

            'start_time'    => 'required|date_format:H:i',

            'end_time'      => 'required|date_format:H:i|after:start_time',

            'venue'         => 'nullable|string|max:255',

            'status'        => 'required|boolean',
        ];
    }
}