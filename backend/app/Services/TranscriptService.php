<?php

namespace App\Services;

use App\Models\Transcript;
use App\Models\Result;

class TranscriptService
{
    public function generate(int $studentId, int $semesterId): Transcript
    {
        $results = Result::with('enrollment.course')
            ->whereHas('enrollment', function ($query) use ($studentId, $semesterId) {
                $query->where('student_id', $studentId)
                      ->where('semester_id', $semesterId);
            })
            ->get();

        $totalCredits = 0;
        $totalGradePoints = 0;

        foreach ($results as $result) {

            $credit = $result->enrollment->course->credit;
            $gradePoint = $result->grade_point;

            $totalCredits += $credit;
            $totalGradePoints += ($credit * $gradePoint);
        }

        $semesterGpa = $totalCredits > 0
            ? round($totalGradePoints / $totalCredits, 2)
            : 0;

        $cgpa = $semesterGpa;

        $transcript = Transcript::updateOrCreate(
            [
                'student_id' => $studentId,
                'semester_id' => $semesterId,
            ],
            [
                'semester_gpa' => $semesterGpa,
                'cgpa' => $cgpa,
                'total_credits' => $totalCredits,
                'status' => 'Published',
            ]
        );

        
        $transcripts = Transcript::where('student_id', $studentId)
            ->orderBy('semester_id')
            ->get();

        $totalCredits = 0;
        $totalGradePoints = 0;

        foreach ($transcripts as $item) {
            $totalCredits += $item->total_credits;
            $totalGradePoints += $item->semester_gpa * $item->total_credits;
        }

        $cgpa = $totalCredits > 0
            ? round($totalGradePoints / $totalCredits, 2)
            : 0;

        Transcript::where('student_id', $studentId)
            ->update([
                'cgpa' => $cgpa,
            ]);

        $transcript->refresh();

        return $transcript;
    }
}