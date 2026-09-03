<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\TeacherReportResource;
use App\Services\TeacherReportService;
use App\Http\Resources\TeacherCourseAssignmentReportResource;

class TeacherReportController extends Controller
{
    protected TeacherReportService $teacherReportService;

    public function __construct(
        TeacherReportService $teacherReportService
    ) {
        $this->teacherReportService = $teacherReportService;
    }

    /**
     * Single teacher report
     */
    public function teacher(int $teacherId)
    {
        $teacher = $this->teacherReportService
            ->teacherReport($teacherId);

        return ApiResponse::success(
            new TeacherReportResource($teacher),
            'Teacher report retrieved successfully.'
        );
    }

    /**
     * Department-wise teacher report
     */
    public function department(int $departmentId)
    {
        $teachers = $this->teacherReportService
            ->departmentReport($departmentId);

        return ApiResponse::success(
            TeacherReportResource::collection($teachers),
            'Department-wise teacher report retrieved successfully.'
        );
    }

    /**
     * Active teachers report
     */
    public function active()
    {
        $teachers = $this->teacherReportService
            ->activeTeachers();

        return ApiResponse::success(
            TeacherReportResource::collection($teachers),
            'Active teachers report retrieved successfully.'
        );
    }

    /**
     * Inactive teachers report
     */
    public function inactive()
    {
        $teachers = $this->teacherReportService
            ->inactiveTeachers();

        return ApiResponse::success(
            TeacherReportResource::collection($teachers),
            'Inactive teachers report retrieved successfully.'
        );
    }

    public function assignedCourses(int $teacherId)
    {
        $assignments = $this->teacherReportService
            ->assignedCoursesReport($teacherId);

        return ApiResponse::success(
            TeacherCourseAssignmentReportResource::collection(
                $assignments
            ),
            'Teacher assigned courses retrieved successfully.'
        );
    }

    /**
     * Teacher summary report
     */
    public function summary()
    {
        return ApiResponse::success(
            $this->teacherReportService->teacherSummary(),
            'Teacher summary retrieved successfully.'
        );
    }

    /**
    * Teacher date range report
    */
    public function dateRange(Request $request)
    {
        $validated = $request->validate([
            'from' => ['required', 'date'],
            'to' => ['required', 'date', 'after_or_equal:from'],
        ]);

        $teachers = $this->teacherReportService
            ->dateRangeReport(
                $validated['from'],
                $validated['to']
            );

        return ApiResponse::success(
            TeacherReportResource::collection($teachers),
            'Teacher date range report retrieved successfully.'
        );
    }

    
}