<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherDashboardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [

            'assigned_courses' => TeacherCourseAssignmentResource::collection(
                $this['assigned_courses']
            ),

            'today' => [

                'routine' => RoutineResource::collection(
                    $this['today']['routine']
                ),

                'total_classes' => $this['today']['total_classes'],

            ],

            'pending' => [

                'attendance' => $this['pending']['attendance'],

                'marks' => $this['pending']['marks'],

            ],

        ];
    }
}