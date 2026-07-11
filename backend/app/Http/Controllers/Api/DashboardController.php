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

class DashboardController extends Controller
{
    protected DashboardService $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }
    //
    public function index()
{
    return response()->json([
        'success' => true,
        'message' => 'Dashboard data fetched successfully.',
        'data' => $this->dashboardService->getDashboardData(),
    ]);
}
}
