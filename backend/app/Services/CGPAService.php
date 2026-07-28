<?php

namespace App\Services;

use App\Models\Result;
use App\Services\Policies\GradeCalculationService;
use App\Models\Student;

class CGPAService
{
    public function __construct(
        protected GradeCalculationService $gradePolicy
    ) {}

    public function calculate(int $studentId): array
    {
        $results = Result::where('student_id', $studentId)
            ->where('status', true)
            ->orderBy('semester_id')
            ->get();

        $totalCredit = 0;
        $earnedCredit = 0;
        $totalGradePoint = 0;

        foreach ($results as $result) {

            $totalCredit += $result->total_credit;

            $earnedCredit += $result->earned_credit;

            $totalGradePoint += $result->total_grade_point;

        }

        $cgpa = $this->gradePolicy->calculateGpa(
            $totalGradePoint,
            $totalCredit
        );

        $student = Student::findOrFail($studentId);

        return [

            'student_id' => $studentId,

            'total_semester' => $results->count(),

            'total_credit' => $totalCredit,

            'earned_credit' => $earnedCredit,

            'total_grade_point' => round($totalGradePoint, 2),

            'cgpa' => $cgpa,

            'result_status' => $this->gradePolicy
                ->calculateResultStatus($cgpa),

            'results' => $results,
            'student' => $student,

        ];
    }
}