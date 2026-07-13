<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttendanceRequest;
use App\Models\Attendance;
use App\Http\Resources\AttendanceResource;
use Illuminate\Http\Request;
use App\Helpers\QueryFilter;

class AttendanceController extends Controller
{
    
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
    public function index()
    {
        $attendances = QueryFilter::apply(
            Attendance::with([
                'student',
                'course'
            ]),
            $request,

            [],

            [
                'student_id',
                'course_id',
                'status'
            ],

            [
                'id',
                'attendance_date',
                'created_at'
            ]
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
    public function store(AttendanceRequest $request)
    {
        $attendance = Attendance::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Attendance created successfully.',
            'data' => $attendance,
        ], 201);
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
        $attendance->load([
            'student',
            'course',
            'semester',
        ]);

        return response()->json([
            'success' => true,
            'data' => new AttendanceResource($attendance),
        ]);
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
    public function update(AttendanceRequest $request, Attendance $attendance)
    {
        $attendance->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Attendance updated successfully.',
            'data' => $attendance,
        ]);
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
        $attendance->delete();

        return response()->json([
            'success' => true,
            'message' => 'Attendance deleted successfully.',
        ]);
    }
}