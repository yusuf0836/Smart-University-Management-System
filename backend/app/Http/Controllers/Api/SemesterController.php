<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSemesterRequest;
use App\Http\Requests\UpdateSemesterRequest;
use App\Http\Resources\SemesterResource;
use App\Models\Semester;
use App\Services\SemesterService;

class SemesterController extends Controller
{
    public function __construct(
        protected SemesterService $service
    ) {}
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
    public function index()
    {
        $semesters = Semester::latest()->paginate(10);

        return ApiResponse::success(
            SemesterResource::collection($semesters),
            'Semesters retrieved successfully.',
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
    public function store(StoreSemesterRequest $request)
    {
        $semester = $this->service->store(
            $request->validated()
        );

        return ApiResponse::created(
            new SemesterResource($semester),
            'Semester created successfully.'
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
            'Semester retrieved successfully.'
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
    public function update(
        UpdateSemesterRequest $request,
        Semester $semester
    ) {
        $semester = $this->service->update(
            $semester,
            $request->validated()
        );

        return ApiResponse::success(
            new SemesterResource($semester),
            'Semester updated successfully.'
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
        $this->service->destroy($semester);

        return ApiResponse::deleted(
            'Semester deleted successfully.'
        );
    }
}