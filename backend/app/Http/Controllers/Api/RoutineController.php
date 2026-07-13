<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoutineRequest;
use App\Models\Routine;
use App\Http\Resources\RoutineResource;
use Illuminate\Http\Request;
use App\Helpers\QueryFilter;

class RoutineController extends Controller
{
    
    /**
     * List Routines
     *
     * Returns a list of all class routines with department, semester, course and teacher information.
     *
     * @group Routine Management
     *
     * @authenticated
     *
     * @response 200 {"success": true}
     */
    public function index()
    {
        $routines = QueryFilter::apply(
            Routine::with([
                'department',
                'semester',
                'course',
                'teacher'
            ]),
            $request,

            [
                'day'
            ],

            [
                'department_id',
                'semester_id',
                'teacher_id'
            ],

            [
                'id',
                'day',
                'start_time'
            ]
        );
    }

    /**
     * Create Routine
     *
     * Creates a new class routine.
     *
     * @group Routine Management
     *
     * @authenticated
     *
     * @bodyParam department_id integer required Department ID. Example: 1
     * @bodyParam semester_id integer required Semester ID. Example: 2
     * @bodyParam course_id integer required Course ID. Example: 5
     * @bodyParam teacher_id integer required Teacher ID. Example: 3
     * @bodyParam day string required Class day. Allowed values: Saturday, Sunday, Monday, Tuesday, Wednesday, Thursday, Friday. Example: Sunday
     * @bodyParam start_time string required Class start time (24-hour format). Example: 09:00
     * @bodyParam end_time string required Class end time (24-hour format). Must be after start_time. Example: 10:30
     * @bodyParam room_no string required Room number. Example: A-401
     * @bodyParam status boolean required Routine status. Example: true
     *
     * @response 201 {
     *   "success": true,
     *   "message": "Routine created successfully."
     * }
     */
    public function store(RoutineRequest $request)
    {
        $routine = Routine::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Routine created successfully.',
            'data' => $routine,
        ], 201);
    }

    /**
     * Show Routine
     *
     * Returns details of a specific class routine.
     *
     * @group Routine Management
     *
     * @authenticated
     *
     * @urlParam routine integer required Routine ID. Example: 1
     *
     * @response 200 {"success": true}
     */
    public function show(Routine $routine)
    {
        return response()->json([
            'success' => true,
            'data' => $routine->load([
                'department',
                'semester',
                'course',
                'teacher',
            ]),
        ]);
    }

    /**
     * Update Routine
     *
     * Updates an existing class routine.
     *
     * @group Routine Management
     *
     * @authenticated
     *
     * @urlParam routine integer required Routine ID. Example: 1
     *
     * @bodyParam department_id integer required Department ID. Example: 1
     * @bodyParam semester_id integer required Semester ID. Example: 2
     * @bodyParam course_id integer required Course ID. Example: 5
     * @bodyParam teacher_id integer required Teacher ID. Example: 3
     * @bodyParam day string required Class day. Allowed values: Saturday, Sunday, Monday, Tuesday, Wednesday, Thursday, Friday. Example: Sunday
     * @bodyParam start_time string required Class start time (24-hour format). Example: 09:00
     * @bodyParam end_time string required Class end time (24-hour format). Must be after start_time. Example: 10:30
     * @bodyParam room_no string required Room number. Example: A-401
     * @bodyParam status boolean required Routine status. Example: true
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Routine updated successfully."
     * }
     */
    public function update(RoutineRequest $request, Routine $routine)
    {
        $routine->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Routine updated successfully.',
            'data' => $routine,
        ]);
    }

    /**
     * Delete Routine
     *
     * Deletes a class routine.
     *
     * @group Routine Management
     *
     * @authenticated
     *
     * @urlParam routine integer required Routine ID. Example: 1
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Routine deleted successfully."
     * }
     */
    public function destroy(Routine $routine)
    {
        $routine->delete();

        return response()->json([
            'success' => true,
            'message' => 'Routine deleted successfully.',
        ]);
    }
}