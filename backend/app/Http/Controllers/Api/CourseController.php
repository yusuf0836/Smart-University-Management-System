<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Models\Course;
use App\Http\Resources\CourseResource;
use Illuminate\Http\Request;
use App\Helpers\QueryFilter;
use App\Helpers\ApiResponse;

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

        return ApiResponse::success(
            CourseResource::collection($courses),
            'Courses retrieved successfully',
            $courses
        );
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

        return ApiResponse::created(
            new CourseResource($course),
            'Course created successfully'
        );
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

        return ApiResponse::success(
            new CourseResource($course),
            'Course retrieved successfully'
        );
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

        return ApiResponse::success(
            new CourseResource($course),
            'Course updated successfully'
        );
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

        return ApiResponse::deleted(
            'Course deleted successfully'
        );
    }
}