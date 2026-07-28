<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;
use App\Http\Resources\AttendanceResource;
use App\Models\Attendance;
use App\Services\AttendanceService;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    
    public function __construct(
        protected AttendanceService $attendanceService
    ) {}
    /**
     * List Attendances
     *
     * Returns a list of all attendance records with student, course and semester information.
     *
     * @group Attendance Management
     *
     * @authenticated
     *
     * @response 200 {"success": true}
     */
    public function index(Request $request)
    {
        $attendances = Attendance::with([
            'student',
            'course',
            'semester',
            'routine'
        ])
        ->latest()
        ->paginate($request->get('per_page', 10));

        return ApiResponse::success(
            AttendanceResource::collection($attendances),
            'Attendance list retrieved successfully.',
            $attendances
        );
    }

    /**
     * Create Attendance
     *
     * Creates a new attendance record for a student.
     *
     * @group Attendance Management
     *
     * @authenticated
     *
     * @bodyParam student_id integer required Student ID. Example: 1
     * @bodyParam course_id integer required Course ID. Example: 3
     * @bodyParam semester_id integer required Semester ID. Example: 2
     * @bodyParam attendance_date date required Attendance Date. Example: 2026-01-15
     * @bodyParam status string required Attendance Status. Allowed values: Present, Absent, Late. Example: Present
     * @bodyParam remarks string Optional remarks. Example: Arrived 10 minutes late.
     *
     * @response 201 {
     *   "success": true,
     *   "message": "Attendance created successfully."
     * }
     */
    public function store(StoreAttendanceRequest $request)
    {
        $attendance = $this->attendanceService->store(
            $request->validated()
        );

        return ApiResponse::created(
            new AttendanceResource(
                $attendance->load([
                    'student',
                    'course',
                    'semester',
                    'routine'
                ])
            ),
            'Attendance created successfully.'
        );
    }

    /**
     * Show Attendance
     *
     * Returns details of a specific attendance record.
     *
     * @group Attendance Management
     *
     * @authenticated
     *
     * @urlParam attendance integer required Attendance ID. Example: 1
     *
     * @response 200 {"success": true}
     */
    public function show(Attendance $attendance)
    {
        return ApiResponse::success(
            new AttendanceResource(
                $attendance->load([
                    'student',
                    'course',
                    'semester',
                    'routine'
                ])
            ),
            'Attendance retrieved successfully.'
        );
    }

    /**
     * Update Attendance
     *
     * Updates an existing attendance record.
     *
     * @group Attendance Management
     *
     * @authenticated
     *
     * @urlParam attendance integer required Attendance ID. Example: 1
     *
     * @bodyParam student_id integer required Student ID. Example: 1
     * @bodyParam course_id integer required Course ID. Example: 3
     * @bodyParam semester_id integer required Semester ID. Example: 2
     * @bodyParam attendance_date date required Attendance Date. Example: 2026-01-15
     * @bodyParam status string required Attendance Status. Allowed values: Present, Absent, Late. Example: Present
     * @bodyParam remarks string Optional remarks. Example: Attendance updated after verification.
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Attendance updated successfully."
     * }
     */
    public function update(
        UpdateAttendanceRequest $request,
        Attendance $attendance
    ) {
        $attendance = $this->attendanceService->update(
            $attendance,
            $request->validated()
        );

        return ApiResponse::success(
            new AttendanceResource(
                $attendance->load([
                    'student',
                    'course',
                    'semester',
                    'routine'
                ])
            ),
            'Attendance updated successfully.'
        );
    }

    /**
     * Delete Attendance
     *
     * Deletes an attendance record.
     *
     * @group Attendance Management
     *
     * @authenticated
     *
     * @urlParam attendance integer required Attendance ID. Example: 1
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Attendance deleted successfully."
     * }
     */
    public function destroy(Attendance $attendance)
    {
        $this->attendanceService->destroy($attendance);

        return ApiResponse::deleted(
            'Attendance deleted successfully.'
        );
    }
}