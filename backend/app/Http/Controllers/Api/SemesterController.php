<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SemesterRequest;
use App\Models\Semester;
use App\Http\Resources\SemesterResource;
use Illuminate\Http\Request;
use App\Helpers\QueryFilter;
use App\Helpers\ApiResponse;

class SemesterController extends Controller
{
    
    /**
     * List Semesters
     *
     * Returns a list of all semesters.
     *
     * @group Semester Management
     *
     * @authenticated
     *
     * @response 200 {"success": true}
     */
    public function index(Request $request)
    {
        $semesters = QueryFilter::apply(
            Semester::query(),
            $request,

            [
                'name'
            ],

            [
                'status'
            ],

            [
                'id',
                'name',
                'created_at'
            ]
        );

        return ApiResponse::success(
            SemesterResource::collection($semesters),
            'Semesters retrieved successfully',
            $semesters
        );
    }

    /**
     * Create Semester
     *
     * Creates a new semester.
     *
     * @group Semester Management
     *
     * @authenticated
     *
     * @bodyParam name string required Semester Name. Example: Spring 2026
     * @bodyParam semester_code string required Semester Code. Example: SP26
     * @bodyParam start_date date required Semester Start Date. Example: 2026-01-01
     * @bodyParam end_date date required Semester End Date. Example: 2026-05-31
     * @bodyParam status string required Status. Example: Active
     *
     * @response 201 {"success": true}
     */
    public function store(SemesterRequest $request)
    {
        $semester = Semester::create($request->validated());

        return ApiResponse::created(
            new SemesterResource($semester),
            'Semester created successfully'
        );
    }

    /**
     * Show Semester
     *
     * Returns details of a specific semester.
     *
     * @group Semester Management
     *
     * @authenticated
     *
     * @urlParam semester integer required Semester ID. Example: 1
     *
     * @response 200 {"success": true}
     */
    public function show(Semester $semester)
    {
        return ApiResponse::success(
            new SemesterResource($semester),
            'Semester retrieved successfully'
        );
    }

    /**
     * Update Semester
     *
     * Updates an existing semester.
     *
     * @group Semester Management
     *
     * @authenticated
     *
     * @urlParam semester integer required Semester ID. Example: 1
     *
     * @bodyParam name string Semester Name. Example: Spring 2026
     * @bodyParam semester_code string Semester Code. Example: SP26
     * @bodyParam start_date date Semester Start Date. Example: 2026-01-01
     * @bodyParam end_date date Semester End Date. Example: 2026-05-31
     * @bodyParam status string Status. Example: Active
     *
     * @response 200 {"success": true}
     */
    public function update(SemesterRequest $request, Semester $semester)
    {
        $semester->update($request->validated());

        return ApiResponse::success(
            new SemesterResource($semester),
            'Semester updated successfully'
        );
    }

    /**
     * Delete Semester
     *
     * Deletes a semester.
     *
     * @group Semester Management
     *
     * @authenticated
     *
     * @urlParam semester integer required Semester ID. Example: 1
     *
     * @response 200 {"success": true}
     */
    public function destroy(Semester $semester)
    {
        $semester->delete();

        return ApiResponse::deleted(
            'Semester deleted successfully'
        );
    }
}