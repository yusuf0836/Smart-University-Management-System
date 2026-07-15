<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Course;
use App\Models\Department;
use App\Models\Enrollment;
use App\Models\Examination;
use App\Models\Faculty;
use App\Models\Fee;
use App\Models\Notice;
use App\Models\Result;
use App\Models\Semester;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;

class DashboardService
{
    public function getDashboard(User $user): array
    {
        if ($user->hasRole('Super Admin') || $user->hasRole('Admin')) {
            return $this->adminDashboard();
        }

        if ($user->hasRole('Teacher')) {
            return $this->teacherDashboard($user);
        }

        if ($user->hasRole('Student')) {
            return $this->studentDashboard($user);
        }

        return [];
    }

    private function adminDashboard(): array
    {
        return [

            'statistics' => [

                'faculties' => Faculty::count(),

                'departments' => Department::count(),

                'teachers' => Teacher::count(),

                'students' => Student::count(),

                'semesters' => Semester::count(),

                'courses' => Course::count(),

                'enrollments' => Enrollment::count(),

                'results' => Result::count(),

                'attendances' => Attendance::count(),

                'examinations' => Examination::count(),

                'fees' => Fee::count(),

                'notices' => Notice::count(),

            ],

            'recent_students' => Student::latest()->take(5)->get(),

            'recent_notices' => Notice::latest()->take(5)->get(),

            'recent_enrollments' => Enrollment::latest()->take(5)->get(),

            'upcoming_examinations' => Examination::latest()->take(5)->get(),

        ];
    }

    private function teacherDashboard(User $user): array
    {
        return [

            'message' => 'Teacher dashboard is under development.'

        ];
    }

    private function studentDashboard(User $user): array
    {
        return [

            'message' => 'Student dashboard is under development.'

        ];
    }
}