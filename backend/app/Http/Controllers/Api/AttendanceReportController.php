<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\AttendanceReportResource;
use App\Services\AttendanceReportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AttendanceReportController extends Controller
{
    public function __construct(
        protected AttendanceReportService $service
    ) {}

    public function student(int $studentId): JsonResponse
    {
        return ApiResponse::success(

            AttendanceReportResource::collection(

                $this->service->studentReport($studentId)

            ),

            'Student attendance report retrieved successfully.'

        );
    }

    public function course(int $courseId): JsonResponse
    {
        return ApiResponse::success(

            AttendanceReportResource::collection(

                $this->service->courseReport($courseId)

            ),

            'Course attendance report retrieved successfully.'

        );
    }

    public function teacher(int $teacherId): JsonResponse
    {
        return ApiResponse::success(

            AttendanceReportResource::collection(

                $this->service->teacherReport($teacherId)

            ),

            'Teacher attendance report retrieved successfully.'

        );
    }

    public function semester(int $semesterId): JsonResponse
    {
        return ApiResponse::success(

            AttendanceReportResource::collection(

                $this->service->semesterReport($semesterId)

            ),

            'Semester attendance report retrieved successfully.'

        );
    }

    public function summary(): JsonResponse
    {
        return ApiResponse::success(

            $this->service->summaryReport(),

            'Attendance summary retrieved successfully.'

        );
    }

    public function dateRange(Request $request): JsonResponse
    {
        $request->validate([

            'from' => [
                'required',
                'date',
            ],

            'to' => [
                'required',
                'date',
                'after_or_equal:from',
            ],

        ]);

        return ApiResponse::success(

            AttendanceReportResource::collection(

                $this->service->dateRangeReport(

                    $request->from,

                    $request->to

                )

            ),

            'Attendance report retrieved successfully.'

        );
    }

}