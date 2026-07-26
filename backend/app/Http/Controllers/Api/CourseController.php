<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use App\Services\CourseService;

class CourseController extends Controller
{
    public function __construct(
        protected CourseService $service
    ) {}
    
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
    public function index()
    {
        $courses = Course::with([
            'department',
            'semester'
        ])
        ->latest()
        ->paginate(10);

        return ApiResponse::success(
            CourseResource::collection($courses),
            'Courses retrieved successfully.',
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
    public function store(StoreCourseRequest $request)
    {
        $course = $this->service->store(
            $request->validated()
        );

        return ApiResponse::created(
            new CourseResource(
                $course->load([
                    'department',
                    'semester'
                ])
            ),
            'Course created successfully.'
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
        return ApiResponse::success(
            new CourseResource(
                $course->load([
                    'department',
                    'semester'
                ])
            ),
            'Course retrieved successfully.'
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
    public function update(
        UpdateCourseRequest $request,
        Course $course
    ) {

        $course = $this->service->update(
            $course,
            $request->validated()
        );

        return ApiResponse::success(
            new CourseResource(
                $course->load([
                    'department',
                    'semester'
                ])
            ),
            'Course updated successfully.'
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
        $this->service->destroy($course);

        return ApiResponse::deleted(
            'Course deleted successfully.'
        );
    }
}