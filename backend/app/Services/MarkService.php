<?php

namespace App\Services;

use App\Models\Mark;
use App\Models\Examination;
use Illuminate\Validation\ValidationException;

class MarkService
{
    public function store(array $data): Mark
    {
        $this->validateMarks($data);
        $this->validateDuplicate($data);

        [$grade, $gradePoint] = $this->calculateGrade(
            $data['marks_obtained']
        );

        $data['grade'] = $grade;
        $data['grade_point'] = $gradePoint;

        return Mark::create($data);
    }

    public function update(
        Mark $mark,
        array $data
    ): Mark {

        $this->validateMarks($data);

        $this->validateDuplicate($data, $mark);

        [$grade, $gradePoint] = $this->calculateGrade(
            $data['marks_obtained']
        );

        $data['grade'] = $grade;
        $data['grade_point'] = $gradePoint;

        $mark->update($data);

        return $mark->fresh();
    }

    public function destroy(Mark $mark): bool
    {
        return $mark->delete();
    }

    private function validateMarks(array $data): void
    {
        $examination = Examination::findOrFail(
            $data['examination_id']
        );

        if ($data['marks_obtained'] > $examination->total_marks) {

            throw ValidationException::withMessages([
                'marks_obtained' => [
                    'Obtained marks cannot be greater than total marks (' .
                    $examination->total_marks . ').'
                ]
            ]);

        }
    }

    private function validateDuplicate(array $data, ?Mark $mark = null): void
    {
        $query = Mark::where('student_id', $data['student_id'])
            ->where('examination_id', $data['examination_id']);

        // Update 
        if ($mark) {
            $query->where('id', '!=', $mark->id);
        }

        if ($query->exists()) {

            throw ValidationException::withMessages([
                'student_id' => [
                    'This student already has marks for this examination.'
                ]
            ]);

        }
    }

    /**
     * Grade Calculation
     */
    private function calculateGrade(float $marks): array
    {
        if ($marks >= 80) return ['A+', 4.00];

        if ($marks >= 75) return ['A', 3.75];

        if ($marks >= 70) return ['A-', 3.50];

        if ($marks >= 65) return ['B+', 3.25];

        if ($marks >= 60) return ['B', 3.00];

        if ($marks >= 55) return ['B-', 2.75];

        if ($marks >= 50) return ['C+', 2.50];

        if ($marks >= 45) return ['C', 2.25];

        if ($marks >= 40) return ['D', 2.00];

        return ['F', 0.00];
    }
}