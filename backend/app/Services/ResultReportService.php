<?php

namespace App\Services;

use App\Models\Result;

class ResultReportService
{
    public function __construct() {}

    public function studentReport(int $studentId)
    {
        return Result::with([

            'student',

            'semester',

        ])

        ->where('student_id', $studentId)

        ->latest()

        ->get();
    }

    public function semesterReport(int $semesterId)
    {
        return Result::with([

            'student',

            'semester',

        ])

        ->where('semester_id', $semesterId)

        ->latest()

        ->get();
    }

    public function departmentReport(int $departmentId)
    {
        return Result::with([

            'student',

            'semester',

        ])

        ->whereHas('student', function ($query) use ($departmentId) {

            $query->where('department_id', $departmentId);

        })

        ->latest()

        ->get();
    }

    public function passedStudents()
    {
        return Result::with([
            'student',
            'semester',
            'academicSession',
        ])
        ->where('result_status', 'Pass')
        ->latest()
        ->get();
    }

    public function failedStudents()
    {
        return Result::with([
            'student',
            'semester',
            'academicSession',
        ])
        ->where('result_status', 'Fail')
        ->latest()
        ->get();
    }

    public function topStudents(int $limit = 10)
    {
        return Result::with([
            'student',
            'semester',
            'academicSession',
        ])
        ->where('result_status', 'Pass')
        ->orderByDesc('gpa')
        ->take($limit)
        ->get();
    }

    public function gpaReport(): array
    {
        return [

            'average_gpa' => round(
                (float) Result::avg('gpa'),
                2
            ),

            'highest_gpa' => Result::max('gpa'),

            'lowest_gpa' => Result::min('gpa'),

        ];
    }

    public function resultSummary(): array
    {
        return [

            'total_results' => Result::count(),

            'passed_students' => Result::where(
                'result_status',
                'Pass'
            )->count(),

            'failed_students' => Result::where(
                'result_status',
                'Fail'
            )->count(),

            'average_gpa' => round(
                (float) Result::avg('gpa'),
                2
            ),

            'highest_gpa' => Result::max('gpa'),

            'lowest_gpa' => Result::min('gpa'),

        ];
    }

}