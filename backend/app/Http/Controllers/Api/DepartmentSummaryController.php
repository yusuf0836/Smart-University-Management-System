<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\DepartmentSummaryResource;
use App\Services\DepartmentSummaryService;

class DepartmentSummaryController extends Controller
{
    protected DepartmentSummaryService $departmentSummaryService;

    public function __construct(
        DepartmentSummaryService $departmentSummaryService
    ) {
        $this->departmentSummaryService =
            $departmentSummaryService;
    }

    /**
     * Single department summary
     */
    public function department(int $departmentId)
    {
        $summary = $this->departmentSummaryService
            ->departmentSummary($departmentId);

        return ApiResponse::success(
            [
                'department' => new DepartmentSummaryResource(
                    $summary['department']
                ),

                'total_students' =>
                    $summary['total_students'],

                'total_teachers' =>
                    $summary['total_teachers'],

                'total_courses' =>
                    $summary['total_courses'],
            ],
            'Department summary retrieved successfully.'
        );
    }

    /**
     * All departments summary
     */
    public function all()
    {
        $departments = $this->departmentSummaryService
            ->allDepartmentsSummary();

        return ApiResponse::success(
            DepartmentSummaryResource::collection(
                $departments
            ),
            'All departments summary retrieved successfully.'
        );
    }

    /**
     * Detailed department statistics
     */
    public function statistics(int $departmentId)
    {
        $statistics = $this->departmentSummaryService
            ->departmentStatistics($departmentId);

        return ApiResponse::success(
            [
                'department' => new DepartmentSummaryResource(
                    $statistics['department']
                ),

                'students' => $statistics['students'],

                'teachers' => $statistics['teachers'],

                'courses' => $statistics['courses'],
            ],
            'Department statistics retrieved successfully.'
        );
    }

    /**
     * Overall university statistics
     */
    public function overall()
    {
        $statistics = $this->departmentSummaryService
            ->overallStatistics();

        return ApiResponse::success(
            $statistics,
            'Overall department statistics retrieved successfully.'
        );
    }
}