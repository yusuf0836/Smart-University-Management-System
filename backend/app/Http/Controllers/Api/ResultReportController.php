<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ResultReportResource;
use App\Services\ResultReportService;

class ResultReportController extends Controller
{
    protected ResultReportService $resultReportService;

    public function __construct(
        ResultReportService $resultReportService
    ) {
        $this->resultReportService = $resultReportService;
    }

    public function student(int $studentId)
    {
        $results = $this->resultReportService
            ->studentReport($studentId);

        return ApiResponse::success(
            ResultReportResource::collection($results),
            'Student result report retrieved successfully.'
        );
    }

    public function semester(int $semesterId)
    {
        $results = $this->resultReportService
            ->semesterReport($semesterId);

        return ApiResponse::success(
            ResultReportResource::collection($results),
            'Semester result report retrieved successfully.'
        );
    }

    public function department(int $departmentId)
    {
        $results = $this->resultReportService
            ->departmentReport($departmentId);

        return ApiResponse::success(
            ResultReportResource::collection($results),
            'Department result report retrieved successfully.'
        );
    }

    public function passedStudents()
    {
        $results = $this->resultReportService
            ->passedStudents();

        return ApiResponse::success(
            ResultReportResource::collection($results),
            'Passed students result report retrieved successfully.'
        );
    }

    public function failedStudents()
    {
        $results = $this->resultReportService
            ->failedStudents();

        return ApiResponse::success(
            ResultReportResource::collection($results),
            'Failed students result report retrieved successfully.'
        );
    }

    public function topStudents()
    {
        $results = $this->resultReportService
            ->topStudents();

        return ApiResponse::success(
            ResultReportResource::collection($results),
            'Top students result report retrieved successfully.'
        );
    }

    public function gpaReport()
    {
        return ApiResponse::success(
            $this->resultReportService->gpaReport(),
            'GPA report retrieved successfully.'
        );
    }

    public function summary()
    {
        return ApiResponse::success(
            $this->resultReportService->resultSummary(),
            'Result summary retrieved successfully.'
        );
    }
}