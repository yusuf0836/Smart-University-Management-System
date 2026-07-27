<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoutineRequest;
use App\Http\Requests\UpdateRoutineRequest;
use App\Http\Resources\RoutineResource;
use App\Models\Routine;
use App\Services\RoutineService;
use Illuminate\Http\Request;

class RoutineController extends Controller
{
    public function __construct(
        protected RoutineService $service
    ) {}

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
    public function index(Request $request)
    {
        $routines = Routine::with([
            'department',
            'semester',
            'course',
            'teacher',
        ])
        ->latest()
        ->paginate($request->get('per_page', 10));

        return ApiResponse::success(
            RoutineResource::collection($routines),
            'Routine list retrieved successfully.',
            $routines
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
    public function store(StoreRoutineRequest $request)
    {
        $routine = $this->service->store(
            $request->validated()
        );

        return ApiResponse::created(
            new RoutineResource(
                $routine->load([
                    'department',
                    'semester',
                    'course',
                    'teacher',
                ])
            ),
            'Routine created successfully.'
        );
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
        return ApiResponse::success(
            new RoutineResource(
                $routine->load([
                    'department',
                    'semester',
                    'course',
                    'teacher',
                ])
            ),
            'Routine retrieved successfully.'
        );
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
    public function update(
        UpdateRoutineRequest $request,
        Routine $routine
    ) {
        $routine = $this->service->update(
            $routine,
            $request->validated()
        );

        return ApiResponse::success(
            new RoutineResource(
                $routine->load([
                    'department',
                    'semester',
                    'course',
                    'teacher',
                ])
            ),
            'Routine updated successfully.'
        );
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
        $this->service->destroy($routine);

        return ApiResponse::deleted(
            'Routine deleted successfully.'
        );
    }
}