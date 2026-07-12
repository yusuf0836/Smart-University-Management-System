<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeacherRequest;
use App\Models\Teacher;
use App\Http\Resources\TeacherResource;

class TeacherController extends Controller
{
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
    public function index()
    {
        $teachers = Teacher::with('department')->latest()->get();

        return response()->json([
            'success' => true,
            'data' => TeacherResource::collection($teachers),
        ]);
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
    public function store(TeacherRequest $request)
    {
        $teacher = Teacher::create($request->validated());

        return response()->json([
            'data' => $teacher
        ], 201);
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
        $teacher->load('department');

        return response()->json([
            'success' => true,
            'data' => new TeacherResource($teacher),
        ]);
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
    public function update(TeacherRequest $request, Teacher $teacher)
    {
        $teacher->update($request->validated());

        return response()->json([
            'data' => $teacher
        ]);
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
        $teacher->delete();

        return response()->json([
            'message' => 'Teacher deleted successfully'
        ]);
    }
}