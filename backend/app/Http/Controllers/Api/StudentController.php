<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Models\Student;
use App\Http\Resources\StudentResource;

class StudentController extends Controller
{
    /**
    * List Students
    *
    * Returns a list of all students with their department and semester.
    *
    * @group Student Management
    *
    * @authenticated
    *
    * @response 200 {
    *   "success": true,
    *   "data": [
    *     {
    *       "id": 1,
    *       "student_id": "20230001",
    *       "name": "Md Yusuf Ali",
    *       "email": "yusuf@example.com"
    *     }
    *   ]
    * }
    */

    public function index()
    {
        $students = Student::with([
            'department',
            'semester'
        ])->latest()->get();

        return response()->json([
            'success' => true,
            'data' => StudentResource::collection($students)
        ]);
    }

    /**
     * Create Student
     *
     * Create a new student.
     *
     * @group Student Management
     *
     * @authenticated
     *
     * @bodyParam student_id string required Student ID. Example: 20230001
     * @bodyParam name string required Student Name. Example: Md Yusuf Ali
     * @bodyParam email string required Email Address. Example: yusuf@example.com
     * @bodyParam phone string Phone Number. Example: 01700000000
     *
     * @response 201 {
     *   "success": true,
     *   "message": "Student created successfully."
     * }
     */
    public function store(StudentRequest $request)
    {
        $student = Student::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Student created successfully.',
            'data' => $student
        ], 201);
    }

    /**
     * Show Student
     *
     * Returns details of a specific student.
     *
     * @group Student Management
     *
     * @authenticated
     *
     * @urlParam student integer required Student ID. Example: 1
     *
     * @response 200 {
     *   "success": true,
     *   "data": {
     *     "id": 1,
     *     "student_id": "20230001",
     *     "student_name": "Md Yusuf Ali"
     *   }
     * }
     */
    public function show(Student $student)
    {
        $student->load([
            'department',
            'semester'
        ]);

        return response()->json([
            'success' => true,
            'data' => new StudentResource($student)
        ]);
    }

    /**
     * Update Student
     *
     * Updates an existing student's information.
     *
     * @group Student Management
     *
     * @authenticated
     *
     * @urlParam student integer required The ID of the student. Example: 1
     *
     * @bodyParam student_id string Student ID. Example: 20230001
     * @bodyParam name string Student Name. Example: Md Yusuf Ali
     * @bodyParam email string Email Address. Example: yusuf@example.com
     * @bodyParam phone string Phone Number. Example: 01712345678
     * @bodyParam department_id integer Department ID. Example: 1
     * @bodyParam semester_id integer Semester ID. Example: 2
     * @bodyParam gender string Gender. Example: Male
     * @bodyParam blood_group string Blood Group. Example: O+
     * @bodyParam status string Status. Example: Active
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Student updated successfully."
     * }
     */
    public function update(StudentRequest $request, Student $student)
    {
        $student->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Student updated successfully.',
            'data' => $student
        ]);
    }

    /**
     * Delete Student
     *
     * Deletes a student from the system.
     *
     * @group Student Management
     *
     * @authenticated
     *
     * @urlParam student integer required The ID of the student. Example: 1
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Student deleted successfully."
     * }
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return response()->json([
            'success' => true,
            'message' => 'Student deleted successfully.'
        ]);
    }
}