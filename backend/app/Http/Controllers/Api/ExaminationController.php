<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExaminationRequest;
use App\Models\Examination;
use App\Http\Resources\ExaminationResource;
use Illuminate\Http\Request;
use App\Helpers\QueryFilter;
use App\Helpers\ApiResponse;

class ExaminationController extends Controller
{
    
    /**
     * List Examinations
     *
     * Returns a list of all examinations with department and semester information.
     *
     * @group Examination Management
     *
     * @authenticated
     *
     * @response 200 {"success": true}
     */
    public function index(Request $request)
    {
        $examinations = QueryFilter::apply(
            Examination::with([
                'department',
                'semester'
            ]),
            $request,

            [
                'title'
            ],

            [
                'department_id',
                'semester_id',
                'status'
            ],

            [
                'id',
                'exam_date',
                'created_at'
            ]
        );

        return ApiResponse::success(
            ExaminationResource::collection($examinations),
            'Examinations retrieved successfully',
            $examinations
        );
    }

    /**
     * Create Examination
     *
     * Creates a new examination schedule.
     *
     * @group Examination Management
     *
     * @authenticated
     *
     * @bodyParam department_id integer required Department ID. Example: 1
     * @bodyParam semester_id integer required Semester ID. Example: 2
     * @bodyParam exam_name string required Examination name. Example: Mid Term Examination
     * @bodyParam exam_type string required Examination type. Allowed values: Mid, Final, Quiz, Assignment, Practical, Viva, Improvement. Example: Mid
     * @bodyParam exam_date date required Examination date. Example: 2026-08-15
     * @bodyParam start_time string required Start time (24-hour format). Example: 09:00
     * @bodyParam end_time string required End time (24-hour format). Example: 12:00
     * @bodyParam venue string Examination venue. Example: Room 401
     * @bodyParam status boolean required Examination status. Example: true
     *
     * @response 201 {
     *   "success": true,
     *   "message": "Examination created successfully."
     * }
     */
    public function store(ExaminationRequest $request)
    {
        $examination = Examination::create($request->validated());

        return ApiResponse::created(
            new ExaminationResource($examination),
            'Examination created successfully'
        );
    }

    /**
     * Show Examination
     *
     * Returns details of a specific examination.
     *
     * @group Examination Management
     *
     * @authenticated
     *
     * @urlParam examination integer required Examination ID. Example: 1
     *
     * @response 200 {"success": true}
     */
    public function show(Examination $examination)
    {
        $examination->load([
            'department',
            'semester',
        ]);

        return ApiResponse::success(
            new ExaminationResource($examination),
            'Examination retrieved successfully'
        );
    }

    /**
     * Update Examination
     *
     * Updates an existing examination schedule.
     *
     * @group Examination Management
     *
     * @authenticated
     *
     * @urlParam examination integer required Examination ID. Example: 1
     *
     * @bodyParam department_id integer required Department ID. Example: 1
     * @bodyParam semester_id integer required Semester ID. Example: 2
     * @bodyParam exam_name string required Examination name. Example: Final Examination
     * @bodyParam exam_type string required Examination type. Allowed values: Mid, Final, Quiz, Assignment, Practical, Viva, Improvement. Example: Final
     * @bodyParam exam_date date required Examination date. Example: 2026-12-20
     * @bodyParam start_time string required Start time (24-hour format). Example: 10:00
     * @bodyParam end_time string required End time (24-hour format). Example: 13:00
     * @bodyParam venue string Examination venue. Example: Main Hall
     * @bodyParam status boolean required Examination status. Example: true
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Examination updated successfully."
     * }
     */
    public function update(ExaminationRequest $request, Examination $examination)
    {
        $examination->update($request->validated());

        return ApiResponse::success(
            new ExaminationResource($examination),
            'Examination updated successfully'
        );
    }

    /**
     * Delete Examination
     *
     * Deletes an examination schedule.
     *
     * @group Examination Management
     *
     * @authenticated
     *
     * @urlParam examination integer required Examination ID. Example: 1
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Examination deleted successfully."
     * }
     */
    public function destroy(Examination $examination)
    {
        $examination->delete();

        return ApiResponse::deleted(
            'Examination deleted successfully'
        );
    }
}