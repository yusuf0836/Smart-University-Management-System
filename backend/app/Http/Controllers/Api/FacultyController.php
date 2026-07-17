<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFacultyRequest;
use App\Http\Requests\UpdateFacultyRequest;
use App\Http\Resources\FacultyResource;
use App\Models\Faculty;
use Illuminate\Http\Request;
use App\Helpers\QueryFilter;
use App\Helpers\ApiResponse;
use App\Services\FacultyService;
use Illuminate\Validation\ValidationException;

class FacultyController extends Controller
{
    public function __construct(
        protected FacultyService $service
    ) {}
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
        $query = Faculty::query();

        /**
         * Search
         */
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");

            });
        }

        /**
         * Status Filter
         */
        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );

        }

        /**
         * Sorting
         */
        if ($request->sort == 'oldest') {

            $query->oldest();

        } else {

            $query->latest();

        }

        /**
         * Pagination
         */
        $perPage = $request->get('per_page', 10);

        $faculties = $query->paginate($perPage);

        return ApiResponse::success(
            FacultyResource::collection($faculties),
            'Faculty list retrieved successfully.',
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

        $faculty = $this->service->store(
            $request->validated()
        );

        return ApiResponse::created(
            new FacultyResource($faculty),
            'Faculty created successfully.'
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
        $faculty = $this->service->update(
            $faculty,
            $request->validated()
        );

        return ApiResponse::success(
            new FacultyResource($faculty),
            'Faculty updated successfully.'
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
        $this->service->destroy($faculty);

        return ApiResponse::deleted(
            'Faculty deleted successfully'
        );
    }
}