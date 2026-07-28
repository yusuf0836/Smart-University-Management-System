<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExaminationRequest extends FormRequest
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

            'academic_session_id' => [
                'required',
                'exists:academic_sessions,id',
            ],

            'department_id' => [
                'required',
                'exists:departments,id',
            ],

            'semester_id' => [
                'required',
                'exists:semesters,id',
            ],

            'course_id' => [
                'required',
                'exists:courses,id',
            ],

            'exam_name' => [
                'required',
                'string',
                'max:255',
            ],

            'exam_type' => [
                'required',
                'in:Mid,Final,Quiz,Assignment,Practical,Viva,Improvement',
            ],

            'exam_date' => [
                'required',
                'date',
            ],

            'start_time' => [
                'required',
                'date_format:H:i',
            ],

            'end_time' => [
                'required',
                'date_format:H:i',
                'after:start_time',
            ],

            'venue' => [
                'nullable',
                'string',
                'max:255',
            ],

            'total_marks' => [
                'required',
                'numeric',
                'min:1',
            ],

            'pass_marks' => [
                'required',
                'numeric',
                'gte:0',
                'lte:total_marks',
            ],

            'status' => [
                'nullable',
                'boolean',
            ],

            'remarks' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ];
    }

    public function messages(): array
    {
        return [

            'end_time.after' => 'End time must be greater than start time.',

            'pass_marks.lte' => 'Pass marks cannot be greater than total marks.',

            'exam_type.in' => 'Invalid examination type.',
        ];
    }
}