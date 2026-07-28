<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NoticeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'title' => $this->title,

            'description' => $this->description,

            'category' => $this->category,

            'audience' => $this->audience,

            'publish_date' => optional($this->publish_date)
                ->format('Y-m-d'),

            'expiry_date' => optional($this->expiry_date)
                ->format('Y-m-d'),

            'is_pinned' => $this->is_pinned,

            'status' => $this->status,

            'attachment' => $this->attachment
                ? asset('storage/' . $this->attachment)
                : null,

            'creator' => $this->whenLoaded('creator', function () {

                return [

                    'id' => $this->creator->id,

                    'name' => $this->creator->name,

                    'email' => $this->creator->email,

                ];

            }),

            'created_at' => optional($this->created_at)
                ->format('Y-m-d H:i:s'),

            'updated_at' => optional($this->updated_at)
                ->format('Y-m-d H:i:s'),

        ];
    }
}