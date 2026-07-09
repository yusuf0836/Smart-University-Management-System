<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttendanceRequest;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    /**
     * Display all attendances.
     */
    public function index()
    {
        $attendances = Attendance::with([
            'student',
            'course',
            'semester'
        ])->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $attendances,
        ]);
    }

    /**
     * Store a newly created attendance.
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
     * Display the specified attendance.
     */
    public function show(Attendance $attendance)
    {
        return response()->json([
            'success' => true,
            'data' => $attendance->load([
                'student',
                'course',
                'semester'
            ]),
        ]);
    }

    /**
     * Update the specified attendance.
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
     * Remove the specified attendance.
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