<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
use App\Http\Resources\TeacherResource;
use App\Models\Teacher;
use App\Services\TeacherService;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function __construct(
        protected TeacherService $service
    ) {}

    /**
     * List Teachers
     *
     * Returns a list of all teachers with their department information.
     *
     * @group Teacher Management
     *
     * @authenticated
     *
     * @response 200 {
     *   "success": true,
     *   "data": [
     *     {
     *       "id": 1,
     *       "employee_id": "EMP001",
     *       "name": "John Doe",
     *       "email": "john@example.com",
     *       "designation": "Assistant Professor"
     *     }
     *   ]
     * }
     */
    public function index(Request $request)
    {
        $teachers = Teacher::query()
            ->with([
                'faculty',
                'department',
            ])
            ->latest()
            ->paginate(
                $request->get('per_page', 10)
            );

        return ApiResponse::success(
            TeacherResource::collection($teachers),
            'Teacher list retrieved successfully.',
            $teachers
        );
    }

    /**
     * Create Teacher
     *
     * Creates a new teacher.
     *
     * @group Teacher Management
     *
     * @authenticated
     *
     * @bodyParam employee_id string required Employee ID. Example: EMP001
     * @bodyParam name string required Teacher Name. Example: John Doe
     * @bodyParam email string required Email Address. Example: john@example.com
     * @bodyParam phone string Phone Number. Example: 01712345678
     * @bodyParam designation string required Designation. Example: Assistant Professor
     * @bodyParam department_id integer required Department ID. Example: 1
     * @bodyParam joining_date date Joining Date. Example: 2026-01-15
     * @bodyParam salary numeric Salary. Example: 50000
     * @bodyParam status string Status. Example: Active
     *
     * @response 201 {
     *   "success": true,
     *   "message": "Teacher created successfully."
     * }
     */
    public function store(StoreTeacherRequest $request)
    {
        $teacher = $this->service->store(
            $request->validated()
        );

        return ApiResponse::created(
            new TeacherResource(
                $teacher->load([
                    'faculty',
                    'department',
                ])
            ),
            'Teacher created successfully.'
        );
    }
    
    /**
     * Show Teacher
     *
     * Returns details of a specific teacher.
     *
     * @group Teacher Management
     *
     * @authenticated
     *
     * @urlParam teacher integer required The ID of the teacher. Example: 1
     *
     * @response 200 {
     *   "success": true,
     *   "data": {
     *     "id": 1,
     *     "employee_id": "EMP001",
     *     "name": "John Doe",
     *     "email": "john@example.com"
     *   }
     * }
     */
    public function show(Teacher $teacher)
    {
        return ApiResponse::success(
            new TeacherResource(
                $teacher->load([
                    'faculty',
                    'department',
                ])
            ),
            'Teacher retrieved successfully.'
        );
    }

    /**
     * Update Teacher
     *
     * Updates an existing teacher.
     *
     * @group Teacher Management
     *
     * @authenticated
     *
     * @urlParam teacher integer required The ID of the teacher. Example: 1
     *
     * @bodyParam name string Teacher Name. Example: John Doe
     * @bodyParam designation string Designation. Example: Associate Professor
     * @bodyParam phone string Phone Number. Example: 01712345678
     * @bodyParam salary numeric Salary. Example: 60000
     * @bodyParam status string Status. Example: Active
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Teacher updated successfully."
     * }
     */
     public function update(
        UpdateTeacherRequest $request,
        Teacher $teacher
    ) {

        $teacher = $this->service->update(
            $teacher,
            $request->validated()
        );

        return ApiResponse::success(
            new TeacherResource(
                $teacher->load([
                    'faculty',
                    'department',
                ])
            ),
            'Teacher updated successfully.'
        );
    }

    /**
     * Delete Teacher
     *
     * Deletes a teacher.
     *
     * @group Teacher Management
     *
     * @authenticated
     *
     * @urlParam teacher integer required The ID of the teacher. Example: 1
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Teacher deleted successfully."
     * }
     */
    public function destroy(Teacher $teacher)
    {
        $this->service->destroy($teacher);

        return ApiResponse::deleted(
            'Teacher deleted successfully.'
        );
    }
}