<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'student' => new StudentResource(
                $this->whenLoaded('student')
            ),

            'semester' => new SemesterResource(
                $this->whenLoaded('semester')
            ),

            'amount' => (float) $this->amount,

            'paid_amount' => (float) $this->paid_amount,

            'due_amount' => (float) $this->due_amount,

            'payment_date' => $this->payment_date?->format('Y-m-d'),

            'payment_method' => $this->payment_method,

            'transaction_id' => $this->transaction_id,

            'status' => $this->status,

            'remarks' => $this->remarks,

            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),

            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}