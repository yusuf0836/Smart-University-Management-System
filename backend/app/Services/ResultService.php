<?php

namespace App\Services;

use App\Models\Enrollment;
use App\Models\Mark;
use App\Models\Result;
use Illuminate\Validation\ValidationException;

class ResultService
{
    public function store(array $data): Result
    {
        $this->validateDuplicate($data);

        $summary = $this->calculateResult($data);

        return Result::create(array_merge($data, $summary));
    }

    public function update(Result $result, array $data): Result
    {
        $this->validateDuplicate($data, $result);

        $summary = $this->calculateResult($data);

        $result->update(array_merge($data, $summary));

        return $result->fresh();
    }

    public function destroy(Result $result): bool
    {
        return $result->delete();
    }

    private function validateDuplicate(array $data, ?Result $result = null): void
    {
        $query = Result::where('student_id', $data['student_id'])
            ->where('semester_id', $data['semester_id'])
            ->where('academic_session_id', $data['academic_session_id']);

        if ($result) {
            $query->where('id', '!=', $result->id);
        }

        if ($query->exists()) {
            throw ValidationException::withMessages([
                'student_id' => [
                    'Result already exists for this student in this semester and academic session.'
                ]
            ]);
        }
    }

    private function calculateResult(array $data): array
    {
        $enrollment = Enrollment::findOrFail($data['enrollment_id']);

        $marks = Mark::where('student_id', $data['student_id'])
            ->whereHas('examination', function ($query) use ($data) {
                $query->where('semester_id', $data['semester_id']);
            })
            ->with('examination.course')
            ->get();

        $totalCredit = 0;
        $earnedCredit = 0;
        $totalGradePoint = 0;

        foreach ($marks as $mark) {

            $credit = $mark->examination->course->credit;

            $totalCredit += $credit;

            if ($mark->grade_point > 0) {
                $earnedCredit += $credit;
            }

            $totalGradePoint += ($mark->grade_point * $credit);
        }

        $gpa = $totalCredit > 0
            ? round($totalGradePoint / $totalCredit, 2)
            : 0;

        return [

            'total_credit' => $totalCredit,

            'earned_credit' => $earnedCredit,

            'total_grade_point' => round($totalGradePoint, 2),

            'gpa' => $gpa,

            'result_status' => $gpa > 0 ? 'Pass' : 'Fail',
        ];
    }
}