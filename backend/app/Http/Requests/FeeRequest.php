<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeeRequest extends FormRequest
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
            'student_id'      => 'required|exists:students,id',
            'semester_id'     => 'required|exists:semesters,id',

            'amount'          => 'required|numeric|min:0',
            'paid_amount'     => 'required|numeric|min:0|lte:amount',
            'due_amount'      => 'required|numeric|min:0',

            'payment_date'    => 'nullable|date',

            'payment_method'  => 'nullable|in:Cash,Bank,Mobile Banking',

            'transaction_id'  => 'nullable|string|max:255',

            'status'          => 'required|in:Paid,Partial,Due',

            'remarks'         => 'nullable|string',
        ];
    }
}