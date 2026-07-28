<?php

namespace App\Services;

use Carbon\Carbon;

use App\Models\Faculty;
use App\Models\Department;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Routine;
use App\Models\Attendance;
use App\Models\Examination;
use App\Models\Result;
use App\Models\TeacherCourseAssignment;

use Illuminate\Support\Facades\Cache;

class DashboardService
{
    /**
     * ==========================================================
     * Admin Dashboard
     * ==========================================================
     */
    public function adminDashboard(): array
    {
        return Cache::remember(

            'admin_dashboard',

            now()->addMinutes(5),

            function () {

                $today = Carbon::today();

                $todayDay = $today->format('l');

                return [

                    /*
                    |--------------------------------------------------------------------------
                    | Statistics
                    |--------------------------------------------------------------------------
                    */

                    'statistics' => [

                        'faculties' => Faculty::count(),

                        'departments' => Department::count(),

                        'teachers' => Teacher::count(),

                        'students' => Student::count(),

                        'courses' => Course::count(),

                        'enrollments' => Enrollment::count(),

                        'examinations' => Examination::count(),

                        'results' => Result::count(),

                    ],

                    /*
                    |--------------------------------------------------------------------------
                    | Today's Summary
                    |--------------------------------------------------------------------------
                    */

                    'today' => [

                        'classes' => Routine::where('day', $todayDay)
                            ->count(),

                        'attendance' => Attendance::whereDate(
                            'attendance_date',
                            $today
                        )->count(),

                        'examinations' => Examination::whereDate(
                            'exam_date',
                            $today
                        )->count(),

                    ],

                    /*
                    |--------------------------------------------------------------------------
                    | Upcoming Examinations
                    |--------------------------------------------------------------------------
                    */

                    'upcoming' => [

                        'examinations' => Examination::with([

                            'department',

                            'semester',

                        ])
                        ->whereDate('exam_date', '>=', $today)
                        ->orderBy('exam_date')
                        ->limit(10)
                        ->get(),

                    ],

                ];

            }

        );
    }
        /**
     * ==========================================================
     * Teacher Dashboard
     * ==========================================================
     */
    public function teacherDashboard(int $teacherId): array
    {
        return Cache::remember(

            "teacher_dashboard_{$teacherId}",

            now()->addMinutes(2),

            function () use ($teacherId) {

                $today = Carbon::today()->format('l');

                $assignedCourses = TeacherCourseAssignment::with([

                    'teacher',

                    'course',

                    'semester',

                    'academicSession',

                ])
                ->where('teacher_id', $teacherId)
                ->where('status', true)
                ->get();

                $todayRoutine = Routine::with([

                    'course',

                    'department',

                    'semester',

                ])
                ->where('teacher_id', $teacherId)
                ->where('day', $today)
                ->where('status', true)
                ->orderBy('start_time')
                ->get();

                /*
                |--------------------------------------------------------------------------
                | Pending Attendance
                |--------------------------------------------------------------------------
                */

                $pendingAttendance = $todayRoutine->count();

                /*
                |--------------------------------------------------------------------------
                | Pending Marks
                |--------------------------------------------------------------------------
                */

                $pendingMarks = $assignedCourses->count();

                return [

                    'assigned_courses' => $assignedCourses,

                    'today' => [

                        'routine' => $todayRoutine,

                        'total_classes' => $todayRoutine->count(),

                    ],

                    'pending' => [

                        'attendance' => $pendingAttendance,

                        'marks' => $pendingMarks,

                    ],

                ];

            }

        );
    }
        /**
     * ==========================================================
     * Student Dashboard
     * ==========================================================
     */
    public function studentDashboard(int $studentId): array
    {
        return Cache::remember(

            "student_dashboard_{$studentId}",

            now()->addMinutes(2),

            function () use ($studentId) {

                $today = Carbon::today();

                $todayDay = $today->format('l');

                $student = Student::findOrFail($studentId);

                $currentSemester = Enrollment::with([
                    'semester',
                ])
                ->where('student_id', $studentId)
                ->latest()
                ->first();

                $enrolledCourses = Enrollment::with([

                    'course',

                    'semester',

                    'academicSession',

                ])
                ->where('student_id', $studentId)
                ->get();

                $todayRoutine = Routine::with([

                    'course',

                    'teacher',

                ])
                ->where('semester_id', optional($currentSemester)->semester_id)
                ->where('day', $todayDay)
                ->where('status', true)
                ->orderBy('start_time')
                ->get();

                $attendanceSummary = [

                    'present' => Attendance::where(
                        'student_id',
                        $studentId
                    )->where(
                        'status',
                        'Present'
                    )->count(),

                    'absent' => Attendance::where(
                        'student_id',
                        $studentId
                    )->where(
                        'status',
                        'Absent'
                    )->count(),

                    'late' => Attendance::where(
                        'student_id',
                        $studentId
                    )->where(
                        'status',
                        'Late'
                    )->count(),

                ];

                $cgpa = app(CGPAService::class)
                    ->calculate($studentId);

                $latestResults = Result::with([
                    'student',
                    'semester',
                    'academicSession',
                    'enrollment',
                    'course',
                ])
                ->where('student_id', $studentId)
                ->where('status', true)
                ->latest()
                ->take(5)
                ->get();

                $upcomingExaminations = Examination::with([

                    'department',

                    'semester',

                ])
                ->whereDate(
                    'exam_date',
                    '>=',
                    $today
                )
                ->where(
                    'semester_id',
                    optional($currentSemester)->semester_id
                )
                ->orderBy('exam_date')
                ->get();

                return [

                    'student' => $student,

                    'current_semester' => optional($currentSemester)->semester,

                    'enrolled_courses' => $enrolledCourses,

                    'today' => [

                        'routine' => $todayRoutine,

                        'total_classes' => $todayRoutine->count(),

                    ],

                    'attendance_summary' => $attendanceSummary,

                    'cgpa' => $cgpa,

                    'latest_result' => $latestResults,

                    'upcoming_examinations' => $upcomingExaminations,

                ];

            }

        );
    }
}