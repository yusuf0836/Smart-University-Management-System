<?php

namespace App\Services;

use App\Models\Mark;
use App\Models\Examination;
use Illuminate\Validation\ValidationException;
use App\Services\Policies\GradeCalculationService;
use App\Services\Policies\ValidationPolicy;

class MarkService
{
    public function __construct(
        protected GradeCalculationService $gradePolicy,
        protected ValidationPolicy $validation
    ) {}

    public function store(array $data): Mark
    {
        $this->validateMarks($data);
        $query = Mark::where('student_id', $data['student_id'])
            ->where('examination_id', $data['examination_id']);

        $this->validation->validateDuplicate(
            $query,
            'student_id',
            'This student already has marks for this examination.'
        );

        [$grade, $gradePoint] = $this->gradePolicy
            ->calculateGrade(
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

        $query = Mark::where('student_id', $data['student_id'])
            ->where('examination_id', $data['examination_id']);

        $this->validation->validateDuplicate(
            $query,
            'student_id',
            'This student already has marks for this examination.',
            $mark->id
        );

        [$grade, $gradePoint] = $this->gradePolicy
            ->calculateGrade(
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


    
}