<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Faculty;
use App\Models\Department;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Notice;
use App\Models\Semester;
use App\Models\Result;
use App\Models\Attendance;
use App\Models\Fee;
use App\Models\Examination;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Services\DashboardService;
use App\Helpers\ApiResponse;

class DashboardController extends Controller
{
    public function __construct(
        protected DashboardService $dashboardService
    ) {}
    
    /**
     * Dashboard Statistics
     *
     * Returns the dashboard summary including statistics, recent activities and analytics.
     *
     * @group Dashboard
     *
     * @authenticated
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Dashboard data fetched successfully.",
     *   "data": {
     *     "total_students": 250,
     *     "total_teachers": 30,
     *     "total_courses": 45,
     *     "total_departments": 5
     *   }
     * }
     */
    public function index(Request $request)
    {
        $dashboard = $this->dashboardService->getDashboard(
            $request->user()
        );

        return ApiResponse::success(
            $dashboard,
            'Dashboard data retrieved successfully.'
        );
    }
}
