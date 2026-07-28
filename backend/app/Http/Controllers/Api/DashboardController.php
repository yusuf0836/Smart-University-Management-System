<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use App\Http\Resources\AdminDashboardResource;
use App\Http\Resources\TeacherDashboardResource;
use App\Http\Resources\StudentDashboardResource;

class DashboardController extends Controller
{
    public function __construct(
        protected DashboardService $service
    ) {}

    public function admin()
    {
        return ApiResponse::success(

            new AdminDashboardResource(

                $this->service->adminDashboard()

            ),

            'Admin dashboard retrieved successfully.'

        );
    }

    public function teacher(int $teacherId)
    {
        return ApiResponse::success(

            new TeacherDashboardResource(

                $this->service->teacherDashboard($teacherId)

            ),

            'Teacher dashboard retrieved successfully.'

        );
    }

    public function student(int $studentId)
    {
        return ApiResponse::success(

            new StudentDashboardResource(

                $this->service->studentDashboard($studentId)

            ),

            'Student dashboard retrieved successfully.'

        );
    }
}