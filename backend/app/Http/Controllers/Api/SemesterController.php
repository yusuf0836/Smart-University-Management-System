<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SemesterRequest;
use App\Models\Semester;
use App\Http\Resources\SemesterResource;

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
    public function index()
    {
        $semesters = Semester::latest()->get();

        return response()->json([
            'success' => true,
            'data' => SemesterResource::collection($semesters),
        ]);
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

        return response()->json([
            'success' => true,
            'message' => 'Semester created successfully.',
            'data' => $semester
        ], 201);
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
        return response()->json([
            'success' => true,
            'data' => new SemesterResource($semester),
        ]);
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

        return response()->json([
            'success' => true,
            'message' => 'Semester updated successfully.',
            'data' => $semester
        ]);
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

        return response()->json([
            'success' => true,
            'message' => 'Semester deleted successfully.'
        ]);
    }
}