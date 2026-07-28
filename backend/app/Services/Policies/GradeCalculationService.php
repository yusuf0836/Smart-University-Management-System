<?php

namespace App\Services\Policies;

class GradeCalculationService
{
    public function calculateGrade(float $marks): array
    {
        return match (true) {

            $marks >= 80 => ['A+', 4.00],

            $marks >= 75 => ['A', 3.75],

            $marks >= 70 => ['A-', 3.50],

            $marks >= 65 => ['B+', 3.25],

            $marks >= 60 => ['B', 3.00],

            $marks >= 55 => ['B-', 2.75],

            $marks >= 50 => ['C+', 2.50],

            $marks >= 45 => ['C', 2.25],

            $marks >= 40 => ['D', 2.00],

            default => ['F', 0.00],

        };
    }

    public function calculateGpa(
        float $totalGradePoint,
        float $totalCredit
    ): float {

        if ($totalCredit <= 0) {
            return 0;
        }

        return round(
            $totalGradePoint / $totalCredit,
            2
        );
    }

    public function calculateResultStatus(
        float $gpa
    ): string {

        return $gpa > 0
            ? 'Pass'
            : 'Fail';
    }
}