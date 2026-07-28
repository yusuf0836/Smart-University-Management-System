<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminDashboardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [

            'statistics' => $this['statistics'],

            'today' => $this['today'],

            'upcoming' => [

                'examinations' => ExaminationResource::collection(
                    $this['upcoming']['examinations']
                ),

            ],

        ];
    }
}