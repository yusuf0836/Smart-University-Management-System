<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\MarksReportResource;
use App\Services\MarksReportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MarksReportController extends Controller
{
    public function __construct(
        protected MarksReportService $service
    ) {}

    public function student(int $studentId): JsonResponse
    {
        return ApiResponse::success(

            MarksReportResource::collection(

                $this->service->studentReport($studentId)

            ),

            'Student marks report retrieved successfully.'

        );
    }

    public function course(int $courseId): JsonResponse
    {
        return ApiResponse::success(

            MarksReportResource::collection(

                $this->service->courseReport($courseId)

            ),

            'Course marks report retrieved successfully.'

        );
    }

    public function teacher(int $teacherId): JsonResponse
    {
        return ApiResponse::success(

            MarksReportResource::collection(

                $this->service->teacherReport($teacherId)

            ),

            'Teacher marks report retrieved successfully.'

        );
    }

    public function semester(int $semesterId): JsonResponse
    {
        return ApiResponse::success(

            MarksReportResource::collection(

                $this->service->semesterReport($semesterId)

            ),

            'Semester marks report retrieved successfully.'

        );
    }

    public function department(int $departmentId): JsonResponse
    {
        return ApiResponse::success(

            MarksReportResource::collection(

                $this->service->departmentReport($departmentId)

            ),

            'Department marks report retrieved successfully.'

        );
    }

    public function examination(int $examinationId): JsonResponse
    {
        return ApiResponse::success(

            MarksReportResource::collection(

                $this->service->examinationReport($examinationId)

            ),

            'Examination marks report retrieved successfully.'

        );
    }

    public function highest(): JsonResponse
    {
        return ApiResponse::success(

            MarksReportResource::collection(

                $this->service->highestMarks()

            ),

            'Highest marks retrieved successfully.'

        );
    }

    public function lowest(): JsonResponse
    {
        return ApiResponse::success(

            MarksReportResource::collection(

                $this->service->lowestMarks()

            ),

            'Lowest marks retrieved successfully.'

        );
    }
    
    public function average(): JsonResponse
    {
        return ApiResponse::success(

            [

                'average_marks' => $this->service->averageMarks(),

            ],

            'Average marks retrieved successfully.'

        );
    }

    public function summary(): JsonResponse
    {
        return ApiResponse::success(

            $this->service->summaryReport(),

            'Marks summary retrieved successfully.'

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

            MarksReportResource::collection(

                $this->service->dateRangeReport(

                    $request->from,

                    $request->to

                )

            ),

            'Marks report retrieved successfully.'

        );
    }

}