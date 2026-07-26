<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use App\Services\StudentService;

class StudentController extends Controller
{
    public function __construct(
        protected StudentService $service
    ) {}

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
            'semester',
            'academicSession'
        ])
        ->latest()
        ->paginate(10);

        return ApiResponse::success(
            StudentResource::collection($students),
            'Students retrieved successfully.',
            $students
        );
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
    public function store(StoreStudentRequest $request)
    {
        $student = $this->service->store(
            $request->validated()
        );

        $student->load([
            'department',
            'semester',
            'academicSession'
        ]);

        return ApiResponse::created(
            new StudentResource($student),
            'Student created successfully.'
        );
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
            'semester',
            'academicSession'
        ]);

        return ApiResponse::success(
            new StudentResource($student),
            'Student retrieved successfully.'
        );
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
    public function update(
        UpdateStudentRequest $request,
        Student $student
    ) {

        $student = $this->service->update(
            $student,
            $request->validated()
        );

        $student->load([
            'department',
            'semester',
            'academicSession'
        ]);

        return ApiResponse::success(
            new StudentResource($student),
            'Student updated successfully.'
        );
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
        $this->service->destroy($student);

        return ApiResponse::deleted(
            'Student deleted successfully.'
        );
    }
}