<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Models\Course;

class CourseController extends Controller
{
    /**
     * Display all courses.
     */
    public function index()
    {
        $courses = Course::with('department')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $courses,
        ]);
    }

    /**
     * Store a newly created course.
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
     * Display the specified course.
     */
    public function show(Course $course)
    {
        return response()->json([
            'success' => true,
            'data' => $course->load('department'),
        ]);
    }

    /**
     * Update the specified course.
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
     * Remove the specified course.
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