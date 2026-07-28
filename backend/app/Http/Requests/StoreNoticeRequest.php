<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNoticeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules.
     */
    public function rules(): array
    {
        return [

            'title' => [
                'required',
                'string',
                'max:255',
                'unique:notices,title',
            ],

            'description' => [
                'required',
                'string',
            ],

            'category' => [
                'required',
                'in:Academic,Examination,Holiday,Event,Admission,Scholarship,General,Emergency',
            ],

            'audience' => [
                'required',
                'in:All,Admin,Teacher,Student',
            ],

            'publish_date' => [
                'required',
                'date',
            ],

            'expiry_date' => [
                'nullable',
                'date',
                'after_or_equal:publish_date',
            ],

            'is_pinned' => [
                'nullable',
                'boolean',
            ],

            'attachment' => [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png,doc,docx',
                'max:5120',
            ],

            'status' => [
                'nullable',
                'boolean',
            ],

        ];
    }
}