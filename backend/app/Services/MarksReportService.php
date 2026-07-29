<?php

namespace App\Services;

use App\Models\Mark;

class MarksReportService
{
    public function __construct() {}

    public function studentReport(int $studentId)
    {
        return Mark::with([
            'student',
            'examination.course',
            'examination.semester',
        ])
        ->where('student_id', $studentId)
        ->latest()
        ->get();
    }

    public function courseReport(int $courseId)
    {
        return Mark::with([
            'student',
            'examination.course',
            'examination.semester',
        ])
        ->whereHas('examination', function ($query) use ($courseId) {

            $query->where('course_id', $courseId);

        })
        ->latest()
        ->get();
    }

    public function examinationReport(int $examinationId)
    {
        return Mark::with([

            'student',

            'examination.course',

            'examination.semester',

            'examination.department',

        ])

        ->where('examination_id', $examinationId)

        ->latest()

        ->get();
    }

    public function teacherReport(int $teacherId)
    {
        return Mark::with([
            'student',
            'examination.course',
            'examination.semester',
        ])

        ->whereHas('examination.course.courseAssignments', function ($query) use ($teacherId) {

            $query->where('teacher_id', $teacherId);

        })

        ->latest()

        ->get();
    }

    public function semesterReport(int $semesterId)
    {
        return Mark::with([
            'student',
            'examination.course',
            'examination.semester',
        ])

        ->whereHas('examination', function ($query) use ($semesterId) {

            $query->where('semester_id', $semesterId);

        })

        ->latest()

        ->get();
    }

    public function departmentReport(int $departmentId)
    {
        return Mark::with([
            'student',
            'examination.course',
            'examination.semester',
        ])

        ->whereHas('examination', function ($query) use ($departmentId) {

            $query->where('department_id', $departmentId);

        })

        ->latest()

        ->get();
    }

    public function highestMarks()
    {
        return Mark::with([
            'student',
            'examination.course',
            'examination.semester',
        ])
        ->orderByDesc('marks_obtained')
        ->take(10)
        ->get();
    }

    public function lowestMarks()
    {
        return Mark::with([
            'student',
            'examination.course',
            'examination.semester',
        ])
        ->orderBy('marks_obtained')
        ->take(10)
        ->get();
    }

    public function averageMarks(): float
    {
        return round(
            Mark::avg('marks_obtained'),
            2
        );
    }

    public function summaryReport(): array
    {
        return [

            'total_marks' => Mark::count(),

            'average_marks' => round(
                Mark::avg('marks_obtained'),
                2
            ),

            'highest_marks' => Mark::max('marks_obtained'),

            'lowest_marks' => Mark::min('marks_obtained'),

        ];
    }

    public function dateRangeReport(
        string $from,
        string $to
    )
    {
        return Mark::with([
            'student',
            'examination.course',
            'examination.semester',
        ])
        ->whereBetween('created_at', [
            $from,
            $to,
        ])
        ->latest()
        ->get();
    }

}