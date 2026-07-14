<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EnrollmentRequest;
use App\Models\Enrollment;
use App\Http\Resources\EnrollmentResource;
use Illuminate\Http\Request;
use App\Helpers\QueryFilter;
use App\Helpers\ApiResponse;

class EnrollmentController extends Controller
{
    
    /**
     * List Enrollments
     *
     * Returns a list of all course enrollments with student, course and semester information.
     *
     * @group Enrollment Management
     *
     * @authenticated
     *
     * @response 200 {"success": true}
     */
    public function index(Request $request)
    {
        $enrollments = QueryFilter::apply(
            Enrollment::with(['student', 'course', 'semester']),
            $request,

            [
                'academic_year',
                'student.name',
                'course.course_title',
                'semester.name'
            ],

            [
                'student_id',
                'course_id',
                'semester_id',
                'status'
            ],

            [
                'id',
                'academic_year',
                'created_at'
            ]
        );

        return ApiResponse::success(
            EnrollmentResource::collection($enrollments),
            'Enrollments retrieved successfully',
            $enrollments
        );
    }

    /**
     * Create Enrollment
     *
     * Enroll a student into a course for a specific semester.
     *
     * @group Enrollment Management
     *
     * @authenticated
     *
     * @bodyParam student_id integer required Student ID. Example: 1
     * @bodyParam course_id integer required Course ID. Example: 5
     * @bodyParam semester_id integer required Semester ID. Example: 2
     * @bodyParam enrollment_date date required Enrollment Date. Example: 2026-01-15
     * @bodyParam status string required Enrollment Status. Allowed values: Enrolled, Dropped, Completed. Example: Enrolled
     *
     * @response 201 {
     *   "success": true,
     *   "message": "Student enrolled successfully."
     * }
     */
    public function store(EnrollmentRequest $request)
    {
        $enrollment = Enrollment::create($request->validated());

        return ApiResponse::created(
            new EnrollmentResource($enrollment),
            'Student enrolled successfully'
        );
    }

    /**
     * Show Enrollment
     *
     * Returns details of a specific enrollment.
     *
     * @group Enrollment Management
     *
     * @authenticated
     *
     * @urlParam enrollment integer required Enrollment ID. Example: 1
     *
     * @response 200 {"success": true}
     */
    public function show(Enrollment $enrollment)
    {
        $enrollment->load([
            'student',
            'course',
            'semester'
        ]);

        return ApiResponse::success(
            new EnrollmentResource($enrollment),
            'Enrollment retrieved successfully'
        );
    }

    /**
     * Update Enrollment
     *
     * Update an existing enrollment.
     *
     * @group Enrollment Management
     *
     * @authenticated
     *
     * @urlParam enrollment integer required Enrollment ID. Example: 1
     *
     * @bodyParam student_id integer required Student ID. Example: 1
     * @bodyParam course_id integer required Course ID. Example: 5
     * @bodyParam semester_id integer required Semester ID. Example: 2
     * @bodyParam enrollment_date date required Enrollment Date. Example: 2026-01-15
     * @bodyParam status string required Enrollment Status. Allowed values: Enrolled, Dropped, Completed. Example: Enrolled
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Enrollment updated successfully."
     * }
     */
    public function update(EnrollmentRequest $request, Enrollment $enrollment)
    {
        $enrollment->update($request->validated());

        return ApiResponse::success(
            new EnrollmentResource($enrollment),
            'Enrollment updated successfully'
        );
    }

    /**
     * Delete Enrollment
     *
     * Deletes an enrollment.
     *
     * @group Enrollment Management
     *
     * @authenticated
     *
     * @urlParam enrollment integer required Enrollment ID. Example: 1
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Enrollment deleted successfully."
     * }
     */
    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();

        return ApiResponse::deleted(
            'Enrollment deleted successfully'
        );
    }
}