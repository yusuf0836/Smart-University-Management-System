<?php

namespace App\Services;

use App\Models\Department;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Course;

class DepartmentSummaryService
{
    /**
     * Single department summary
     */
    public function departmentSummary(int $departmentId): array
    {
        $department = Department::findOrFail($departmentId);

        return [

            'department' => $department,

            'total_students' => $department->students()->count(),

            'total_teachers' => $department->teachers()->count(),

            'total_courses' => $department->courses()->count(),

        ];
    }

    /**
     * All departments summary
     */
    public function allDepartmentsSummary()
    {
        return Department::withCount([
            'students',
            'teachers',
            'courses',
        ])
        ->latest()
        ->get();
    }

    /**
     * Detailed department statistics
     */
    public function departmentStatistics(int $departmentId): array
    {
        $department = Department::findOrFail($departmentId);

        return [

            'department' => $department,

            'students' => [

                'total' => $department->students()->count(),

                'active' => $department->students()
                    ->where('status', true)
                    ->count(),

                'inactive' => $department->students()
                    ->where('status', false)
                    ->count(),

            ],

            'teachers' => [

                'total' => $department->teachers()->count(),

                'active' => $department->teachers()
                    ->where('status', true)
                    ->count(),

                'inactive' => $department->teachers()
                    ->where('status', false)
                    ->count(),

            ],

            'courses' => [

                'total' => $department->courses()->count(),

                'active' => $department->courses()
                    ->where('status', true)
                    ->count(),

                'inactive' => $department->courses()
                    ->where('status', false)
                    ->count(),

            ],

        ];
    }

    /**
     * Overall department statistics
     */
    public function overallStatistics(): array
    {
        return [

            'total_departments' => Department::count(),

            'active_departments' => Department::where(
                'status',
                true
            )->count(),

            'inactive_departments' => Department::where(
                'status',
                false
            )->count(),

            'total_students' => Student::count(),

            'total_teachers' => Teacher::count(),

            'total_courses' => Course::count(),

        ];
    }
}