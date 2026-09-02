<?php

namespace App\Services;

use App\Models\Student;

class StudentReportService
{
    /**
     * Student profile report
     */
    public function studentReport(int $studentId)
    {
        return Student::with([
            'department',
            'semester',
        ])
        ->findOrFail($studentId);
    }

    /**
     * Department-wise students report
     */
    public function departmentReport(int $departmentId)
    {
        return Student::with([
            'department',
            'semester',
        ])
        ->where('department_id', $departmentId)
        ->latest()
        ->get();
    }

    /**
     * Semester-wise students report
     */
    public function semesterReport(int $semesterId)
    {
        return Student::with([
            'department',
            'semester',
        ])
        ->where('semester_id', $semesterId)
        ->latest()
        ->get();
    }

    public function activeStudents()
    {
        return Student::with([
            'department',
            'semester',
        ])
        ->where('status', true)
        ->latest()
        ->get();
    }

    public function inactiveStudents()
    {
        return Student::with([
            'department',
            'semester',
        ])
        ->where('status', false)
        ->latest()
        ->get();
    }

    public function studentSummary(): array
    {
        return [

            'total_students' => Student::count(),

            'active_students' => Student::where(
                'status',
                true
            )->count(),

            'inactive_students' => Student::where(
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
        return Student::with([
            'department',
            'semester',
        ])
        ->whereBetween('created_at', [
            $from,
            $to,
        ])
        ->latest()
        ->get();
    }
}