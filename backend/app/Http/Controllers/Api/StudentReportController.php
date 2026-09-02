<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentReportResource;
use App\Services\StudentReportService;
use Illuminate\Http\Request;

class StudentReportController extends Controller
{
    protected StudentReportService $studentReportService;

    public function __construct(
        StudentReportService $studentReportService
    ) {
        $this->studentReportService = $studentReportService;
    }

    /**
     * Single student report
     */
    public function student(int $studentId)
    {
        $student = $this->studentReportService
            ->studentReport($studentId);

        return ApiResponse::success(
            new StudentReportResource($student),
            'Student report retrieved successfully.'
        );
    }

    /**
     * Department-wise student report
     */
    public function department(int $departmentId)
    {
        $students = $this->studentReportService
            ->departmentReport($departmentId);

        return ApiResponse::success(
            StudentReportResource::collection($students),
            'Department-wise student report retrieved successfully.'
        );
    }

    /**
     * Semester-wise student report
     */
    public function semester(int $semesterId)
    {
        $students = $this->studentReportService
            ->semesterReport($semesterId);

        return ApiResponse::success(
            StudentReportResource::collection($students),
            'Semester-wise student report retrieved successfully.'
        );
    }

    /**
     * Active students
     */
    public function active()
    {
        $students = $this->studentReportService
            ->activeStudents();

        return ApiResponse::success(
            StudentReportResource::collection($students),
            'Active students report retrieved successfully.'
        );
    }

    /**
     * Inactive students
     */
    public function inactive()
    {
        $students = $this->studentReportService
            ->inactiveStudents();

        return ApiResponse::success(
            StudentReportResource::collection($students),
            'Inactive students report retrieved successfully.'
        );
    }

    /**
     * Student summary report
     */
    public function summary()
    {
        return ApiResponse::success(
            $this->studentReportService->studentSummary(),
            'Student summary retrieved successfully.'
        );
    }

    /**
     * Student date range report
     */
    public function dateRange(Request $request)
    {
        $validated = $request->validate([
            'from' => ['required', 'date'],
            'to' => ['required', 'date', 'after_or_equal:from'],
        ]);

        $students = $this->studentReportService
            ->dateRangeReport(
                $validated['from'],
                $validated['to']
            );

        return ApiResponse::success(
            StudentReportResource::collection($students),
            'Student date range report retrieved successfully.'
        );
    }

    
}