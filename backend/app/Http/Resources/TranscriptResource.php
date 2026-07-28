<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TranscriptResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'student' => new StudentResource(
                $this['student']
            ),

            'cgpa' => [

                'total_semester' =>
                    $this['cgpa']['total_semester'],

                'total_credit' =>
                    $this['cgpa']['total_credit'],

                'earned_credit' =>
                    $this['cgpa']['earned_credit'],

                'total_grade_point' =>
                    $this['cgpa']['total_grade_point'],

                'cgpa' =>
                    $this['cgpa']['cgpa'],

                'result_status' =>
                    $this['cgpa']['result_status'],

            ],

            'semester_results' => ResultResource::collection(
                $this['results']
            ),

            'transcript' => [

                'id' => $this['transcript']->id,

                'transcript_no' =>
                    $this['transcript']->transcript_no,

                'status' =>
                    $this['transcript']->status,

                'generated_at' =>
                    $this['transcript']->generated_at,

                'generated_by' =>
                    $this['transcript']->generatedBy,

                'pdf_path' =>
                    $this['transcript']->pdf_path,

            ],

        ];
    }
}