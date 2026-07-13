<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Faculty\StoreFacultyRequest;
use App\Http\Requests\Faculty\UpdateFacultyRequest;
use App\Http\Resources\FacultyResource;
use App\Models\Faculty;
use Illuminate\Http\Request;
use App\Helpers\QueryFilter;
use App\Helpers\ApiResponse;

class FacultyController extends Controller
{
    
    /**
     * List Faculties
     *
     * Returns a list of all faculties.
     *
     * @group Faculty Management
     *
     * @authenticated
     *
     * @response 200 {"success": true}
     */
    public function index(Request $request)
    {
        $faculties = QueryFilter::apply(
            Faculty::query(),
            $request,

            // Search Columns
            [
                'name',
                'code',
                'description',
            ],

            // Filter Columns
            [
                'status',
            ],

            // Sortable Columns
            [
                'id',
                'name',
                'code',
                'description',
                'created_at',
            ]
        );

        return ApiResponse::success(
            FacultyResource::collection($faculties),
            'Faculties retrieved successfully',
            $faculties
        );
    }

    /**
     * Create Faculty
     *
     * Creates a new faculty.
     *
     * @group Faculty Management
     *
     * @authenticated
     *
     * @bodyParam faculty_name string required Faculty Name. Example: Faculty of Engineering
     * @bodyParam faculty_code string required Faculty Code. Example: FE
     *
     * @response 201 {"success": true}
     */
    public function store(StoreFacultyRequest $request)
    {
        $faculty = Faculty::create($request->validated());

        return ApiResponse::created(
            new FacultyResource($faculty),
            'Faculty created successfully'
        );
    }

    /**
     * Show Faculty
     *
     * Returns details of a specific faculty.
     *
     * @group Faculty Management
     *
     * @authenticated
     *
     * @urlParam faculty integer required Faculty ID. Example: 1
     *
     * @response 200 {"success": true}
     */
    public function show(Faculty $faculty)
    {
        return ApiResponse::success(
            new FacultyResource($faculty),
            'Faculty retrieved successfully'
        );
    }

    /**
     * Update Faculty
     *
     * Updates an existing faculty.
     *
     * @group Faculty Management
     *
     * @authenticated
     *
     * @urlParam faculty integer required Faculty ID. Example: 1
     *
     * @response 200 {"success": true}
     */
    public function update(UpdateFacultyRequest $request, Faculty $faculty)
    {
        $faculty->update($request->validated());

        return ApiResponse::success(
            new FacultyResource($faculty),
            'Faculty updated successfully'
        );
    }

    /**
     * Delete Faculty
     *
     * Deletes a faculty.
     *
     * @group Faculty Management
     *
     * @authenticated
     *
     * @urlParam faculty integer required Faculty ID. Example: 1
     *
     * @response 200 {"success": true}
     */
    public function destroy(Faculty $faculty)
    {
        $faculty->delete();

        return ApiResponse::deleted(
            'Faculty deleted successfully'
        );
    }
}