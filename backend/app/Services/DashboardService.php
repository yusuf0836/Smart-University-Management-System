<?php

namespace App\Services;
use App\Models\Attendance;
use App\Models\Course;
use App\Models\Department;
use App\Models\Enrollment;
use App\Models\Exam;
use App\Models\Faculty;
use App\Models\Fee;
use App\Models\Notice;
use App\Models\Result;
use App\Models\Semester;
use App\Models\Student;
use App\Models\Teacher;
use Carbon\Carbon;
use App\Models\Examination;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function getDashboardData()
    {
        return array_merge(
            $this->getGeneralStatistics(),
            [
                'academic' => $this->getAcademicStatistics(),
                'finance' => $this->getFinanceStatistics(),
                'exam' => $this->getExamStatistics(),
                'recent' => $this->getRecentActivities(),
                'charts' => $this->getChartData(),
            ]
        );
    }
    /**
     * Get general statistics for the dashboard
     */
    private function getGeneralStatistics(): array
    {
        return [
            'total_students' => Student::count(),
            'total_teachers' => Teacher::count(),
            'total_faculties' => Faculty::count(),
            'total_departments' => Department::count(),
            'total_courses' => Course::count(),
            'total_enrollments' => Enrollment::count(),
            'total_notices' => Notice::count(),
        ];
    }
    /**
     * Get academic statistics for the dashboard
     */
    private function getAcademicStatistics(): array
    {
        return [
            'total_semesters' => Semester::count(),
            'total_results' => Result::count(),
            'published_results' => Result::whereNotNull('grade')->count(),
            'attendance_records' => Attendance::count(),
        ];
    }
    /**
     * Get finance statistics for the dashboard
     */
    private function getFinanceStatistics(): array
    {
        return [
            'total_fees' => Fee::count(),
            'paid_fees' => Fee::where('due_amount', 0)->count(),
            'partial_fees' => Fee::where('paid_amount', '>', 0)
                ->where('due_amount', '>', 0)
                ->count(),
            'pending_fees' => Fee::where('paid_amount', 0)->count(),
            'total_collected_amount' => Fee::sum('paid_amount'),
            'total_due_amount' => Fee::sum('due_amount'),
        ];
    }
    /**
     * Get exam statistics for the dashboard
     */
    private function getExamStatistics(): array
    {
        return [
            'total_exams' => Examination::count(),
            'upcoming_exams' => Examination::where('exam_date', '>', Carbon::today())->count(),
            'today_exams' => Examination::whereDate('exam_date', Carbon::today())->count(),
            'completed_exams' => Examination::where('exam_date', '<', Carbon::today())->count(),
        ];
    }
    /**
     * Get recent activities for the dashboard
     */
    private function getRecentActivities(): array
    {
        return [
            'students' => Student::latest()->take(5)->get(),
            'notices' => Notice::latest()->take(5)->get(),
            'results' => Result::with([
                'enrollment.student',
                'enrollment.course',
            ])->latest()->take(5)->get(),
        ];
    }
    /**
     * Get chart data for the dashboard
     */
    private function getChartData(): array
    {
        return [
            'charts' => [

                    'students_by_department' => DB::table('students')
                        ->join('departments', 'students.department_id', '=', 'departments.id')
                        ->select(
                            'departments.name',
                            DB::raw('COUNT(students.id) as total_students')
                        )
                        ->groupBy('departments.name')
                        ->get(),
                    
                    'courses_by_department' => DB::table('courses')
                        ->join('departments', 'courses.department_id', '=', 'departments.id')
                        ->select(
                            'departments.name',
                            DB::raw('COUNT(courses.id) as total_courses')
                        )
                        ->groupBy('departments.name')
                        ->get(),
                    'fees_collection' => [
                        'collected' => Fee::sum('paid_amount'),
                        'due' => Fee::sum('due_amount'),
                    ],
                ],
        ];
    }
}