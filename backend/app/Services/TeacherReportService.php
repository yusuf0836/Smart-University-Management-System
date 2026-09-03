<?php

namespace App\Services;

use App\Models\Teacher;
use App\Models\TeacherCourseAssignment;

class TeacherReportService
{
    /**
     * Single teacher report
     */
    public function teacherReport(int $teacherId)
    {
        return Teacher::with([
            'department',
        ])
        ->findOrFail($teacherId);
    }

    /**
     * Department-wise teacher report
     */
    public function departmentReport(int $departmentId)
    {
        return Teacher::with([
            'department',
        ])
        ->where('department_id', $departmentId)
        ->latest()
        ->get();
    }

    public function activeTeachers()
    {
        return Teacher::with([
            'department',
        ])
        ->where('status', true)
        ->latest()
        ->get();
    }

    public function inactiveTeachers()
    {
        return Teacher::with([
            'department',
        ])
        ->where('status', false)
        ->latest()
        ->get();
    }

    public function assignedCoursesReport(int $teacherId)
    {
        return TeacherCourseAssignment::with([
            'teacher',
            'course',
            'department',
            'semester',
        ])
        ->where('teacher_id', $teacherId)
        ->latest()
        ->get();
    }

    public function teacherSummary(): array
    {
        return [

            'total_teachers' => Teacher::count(),

            'active_teachers' => Teacher::where(
                'status',
                true
            )->count(),

            'inactive_teachers' => Teacher::where(
                'status',
                false
            )->count(),

        ];
    }

    public function dateRangeReport(
        string $from,
        string $to
    )
    {
        return Teacher::with([
            'department',
        ])
        ->whereBetween('created_at', [
            $from,
            $to,
        ])
        ->latest()
        ->get();
    }
}