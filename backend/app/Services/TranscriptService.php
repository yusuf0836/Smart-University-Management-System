<?php

namespace App\Services;

use App\Models\Result;
use App\Models\Student;
use App\Models\Transcript;

class TranscriptService
{
    public function __construct(
        protected CGPAService $cgpaService
    ) {}

    public function generate(
        int $studentId,
        int $semesterId
    ): array {

        $student = Student::with([
            'department',
        ])->findOrFail($studentId);

        $results = Result::with([
            'semester',
            'academicSession',
        ])
        ->where('student_id', $studentId)
        ->where('semester_id', $semesterId)
        ->get();

        $cgpa = $this->cgpaService
            ->calculate($studentId);

        $transcript = Transcript::updateOrCreate(

            [
                'student_id' => $studentId,
                'semester_id' => $semesterId,
            ],

            [
                'transcript_no' => 'TEMP-' . time(),

                'generated_by' => auth()->id(),

                'generated_at' => now(),

                'status' => 'Published',
            ]

        );

        return [

            'student' => $student,

            'cgpa' => $cgpa,

            'results' => $results,

            'transcript' => $transcript,

        ];
    }
}