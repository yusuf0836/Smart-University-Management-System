<?php

namespace App\Services;

use App\Models\Attendance;

class AttendanceReportService
{
    public function __construct() {}

    public function studentReport(int $studentId)
    {
        return Attendance::with([

            'student',

            'course',

            'teacher',

            'semester',

        ])

        ->where('student_id', $studentId)

        ->orderByDesc('attendance_date')

        ->get();
    }

    public function courseReport(int $courseId)
    {
        return Attendance::with([

            'student',

            'teacher',

            'semester',

        ])

        ->where('course_id', $courseId)

        ->orderByDesc('attendance_date')

        ->get();
    }

    public function teacherReport(int $teacherId)
    {
        return Attendance::with([

            'student',

            'course',

            'semester',

            'teacher',

        ])

        ->where('teacher_id', $teacherId)

        ->orderByDesc('attendance_date')

        ->get();
    }

    public function semesterReport(int $semesterId)
    {
        return Attendance::with([

            'student',

            'course',

            'teacher',

            'semester',

        ])

        ->where('semester_id', $semesterId)

        ->orderByDesc('attendance_date')

        ->get();
    }

    public function summaryReport(): array
    {
        return [

            'total_records' => Attendance::count(),

            'present' => Attendance::where(
                'status',
                'Present'
            )->count(),

            'absent' => Attendance::where(
                'status',
                'Absent'
            )->count(),

            'late' => Attendance::where(
                'status',
                'Late'
            )->count(),

        ];
    }

    public function dateRangeReport(
        string $from,
        string $to
    )
    {
        return Attendance::with([

            'student',

            'course',

            'teacher',

            'semester',

        ])

        ->whereBetween('attendance_date', [

            $from,

            $to,

        ])

        ->orderByDesc('attendance_date')

        ->get();
    }

}