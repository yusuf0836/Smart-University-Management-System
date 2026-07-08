<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EnrollmentRequest;
use App\Models\Enrollment;

class EnrollmentController extends Controller
{
    /**
     * Display all enrollments.
     */
    public function index()
    {
        $enrollments = Enrollment::with([
            'student',
            'course',
            'semester'
        ])->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $enrollments,
        ]);
    }

    /**
     * Store a newly created enrollment.
     */
    public function store(EnrollmentRequest $request)
    {
        $enrollment = Enrollment::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Student enrolled successfully.',
            'data' => $enrollment,
        ], 201);
    }

    /**
     * Display the specified enrollment.
     */
    public function show(Enrollment $enrollment)
    {
        return response()->json([
            'success' => true,
            'data' => $enrollment->load([
                'student',
                'course',
                'semester'
            ]),
        ]);
    }

    /**
     * Update the specified enrollment.
     */
    public function update(EnrollmentRequest $request, Enrollment $enrollment)
    {
        $enrollment->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Enrollment updated successfully.',
            'data' => $enrollment,
        ]);
    }

    /**
     * Remove the specified enrollment.
     */
    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Enrollment deleted successfully.',
        ]);
    }
}