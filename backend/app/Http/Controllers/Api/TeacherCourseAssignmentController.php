<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeacherCourseAssignmentRequest;
use App\Http\Requests\UpdateTeacherCourseAssignmentRequest;
use App\Http\Resources\TeacherCourseAssignmentResource;
use App\Models\TeacherCourseAssignment;
use App\Services\TeacherCourseAssignmentService;
use Illuminate\Http\Request;

class TeacherCourseAssignmentController extends Controller
{
    public function __construct(
        protected TeacherCourseAssignmentService $service
    ) {}

    /**
     * List Teachers Course Assignment
     */
    public function index(Request $request)
    {
        $assignments = TeacherCourseAssignment::with([
            'teacher',
            'course',
            'semester',
            'academicSession',
        ])
        ->latest()
        ->paginate($request->get('per_page', 10));

        return ApiResponse::success(
            TeacherCourseAssignmentResource::collection($assignments),
            'Teacher course assignment list retrieved successfully.',
            $assignments
        );
    }

    /**
     * Create Teachers Course Assignment
     */

    public function store(StoreTeacherCourseAssignmentRequest $request)
    {
        $assignment = $this->service->store(
            $request->validated()
        );

        return ApiResponse::created(
            new TeacherCourseAssignmentResource(
                $assignment->load([
                    'teacher',
                    'course',
                    'semester',
                    'academicSession',
                ])
            ),
            'Teacher course assigned successfully.'
        );
    }

    /**
     * Show Teachers Course Assignment
     */

    public function show(TeacherCourseAssignment $teacherCourseAssignment)
    {
        return ApiResponse::success(
            new TeacherCourseAssignmentResource(
                $teacherCourseAssignment->load([
                    'teacher',
                    'course',
                    'semester',
                    'academicSession',
                ])
            ),
            'Teacher course assignment retrieved successfully.'
        );
    }

    /**
     * Update Teachers Course Assignment
     */

    public function update(
        UpdateTeacherCourseAssignmentRequest $request,
        TeacherCourseAssignment $teacherCourseAssignment
    ) {

        $teacherCourseAssignment = $this->service->update(
            $teacherCourseAssignment,
            $request->validated()
        );

        return ApiResponse::success(
            new TeacherCourseAssignmentResource(
                $teacherCourseAssignment->load([
                    'teacher',
                    'course',
                    'semester',
                    'academicSession',
                ])
            ),
            'Teacher course assignment updated successfully.'
        );
    }

    /**
     * Delete Teachers Course Assignment
     */

    public function destroy(TeacherCourseAssignment $teacherCourseAssignment)
    {
        $this->service->destroy(
            $teacherCourseAssignment
        );

        return ApiResponse::deleted(
            'Teacher course assignment deleted successfully.'
        );
    }
}