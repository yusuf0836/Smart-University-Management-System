<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Models\Course;
use App\Http\Resources\CourseResource;
use Illuminate\Http\Request;
use App\Helpers\QueryFilter;

class CourseController extends Controller
{
    
    /**
     * List Courses
     *
     * Returns a list of all courses with department and semester information.
     *
     * @group Course Management
     *
     * @authenticated
     *
     * @response 200 {"success": true}
     */
    public function index(Request $request)
    {
        $courses = QueryFilter::apply(
            Course::with('department'),
            $request,

            [
                'course_title',
                'course_code',
                'department.name'
            ],

            [
                'department_id',
                'type',
                'status'
            ],

            [
                'id',
                'course_title',
                'course_code',
                'credit',
                'created_at'
            ]
        );

        return response()->json([
            'success' => true,
            'data' => CourseResource::collection($courses),
            'meta' => [
                'current_page' => $courses->currentPage(),
                'last_page' => $courses->lastPage(),
                'per_page' => $courses->perPage(),
                'total' => $courses->total(),
            ],
        ]);
    }

    /**
     * Create Course
     *
     * Creates a new course.
     *
     * @group Course Management
     *
     * @authenticated
     *
     * @bodyParam department_id integer required Department ID. Example: 1
     * @bodyParam semester_id integer required Semester ID. Example: 1
     * @bodyParam course_code string required Course Code. Example: CSE101
     * @bodyParam course_title string required Course Name. Example: Introduction to Programming
     * @bodyParam credit numeric required Credit Hours. Example: 3
     * @bodyParam course_type string Course Type. Example: Theory
     * @bodyParam status string Status. Example: Active
     *
     * @response 201 {"success": true}
     */
    public function store(CourseRequest $request)
    {
        $course = Course::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Course created successfully.',
            'data' => $course,
        ], 201);
    }

    /**
     * Show Course
     *
     * Returns details of a specific course.
     *
     * @group Course Management
     *
     * @authenticated
     *
     * @urlParam course integer required Course ID. Example: 1
     *
     * @response 200 {"success": true}
     */
    public function show(Course $course)
    {
        $course->load('department');

        return response()->json([
            'success' => true,
            'data' => new CourseResource($course),
        ]);
    }

    /**
     * Update Course
    *
    * Updates an existing course.
    *
    * @group Course Management
    *
    * @authenticated
    *
    * @urlParam course integer required Course ID. Example: 1
    *
    * @bodyParam department_id integer Department ID. Example: 1
    * @bodyParam semester_id integer Semester ID. Example: 1
    * @bodyParam course_code string Course Code. Example: CSE101
    * @bodyParam course_title string Course Name. Example: Introduction to Programming
    * @bodyParam credit numeric Credit Hours. Example: 3
    * @bodyParam course_type string Course Type. Example: Theory
    * @bodyParam status string Status. Example: Active
    *
    * @response 200 {"success": true}
    */
    public function update(CourseRequest $request, Course $course)
    {
        $course->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Course updated successfully.',
            'data' => $course,
        ]);
    }

    /**
     * Delete Course
     *
     * Deletes a course.
     *
     * @group Course Management
     *
     * @authenticated
     *
     * @urlParam course integer required Course ID. Example: 1
     *
     * @response 200 {"success": true}
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return response()->json([
            'success' => true,
            'message' => 'Course deleted successfully.',
        ]);
    }
}