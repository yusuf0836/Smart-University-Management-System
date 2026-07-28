<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreResultRequest;
use App\Http\Requests\UpdateResultRequest;
use App\Http\Resources\ResultResource;
use App\Models\Result;
use App\Services\ResultService;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function __construct(
        protected ResultService $service
    ) {}
    /**
     * List Results
     *
     * Returns a list of all student results with enrollment, student, course and semester information.
     *
     * @group Result Management
     *
     * @authenticated
     *
     * @response 200 {"success": true}
     */
    public function index(Request $request)
    {
        $results = Result::with([
            'enrollment',
            'student',
            'semester',
            'academicSession',
        ])
        ->latest()
        ->paginate($request->get('per_page', 10));

        return ApiResponse::success(
            ResultResource::collection($results),
            'Result list retrieved successfully.',
            $results
        );
    }

    /**
     * Create Result
     *
     * Creates a new examination result for a student's enrollment. Grade and grade point are calculated automatically from the obtained marks.
     *
     * @group Result Management
     *
     * @authenticated
     *
     * @bodyParam enrollment_id integer required Enrollment ID. Example: 1
     * @bodyParam marks number required Obtained marks (0-100). Example: 85
     * @bodyParam remarks string Optional remarks. Example: Excellent performance
     *
     * @response 201 {
     *   "success": true,
     *   "message": "Result created successfully."
     * }
     */
    public function store(StoreResultRequest $request)
    {
        $result = $this->service->store(
            $request->validated()
        );

        return ApiResponse::created(
            new ResultResource(
                $result->load([
                    'enrollment',
                    'student',
                    'semester',
                    'academicSession',
                ])
            ),
            'Result created successfully.'
        );
    }

    /**
     * Show Result
     *
     * Returns details of a specific result.
     *
     * @group Result Management
     *
     * @authenticated
     *
     * @urlParam result integer required Result ID. Example: 1
     *
     * @response 200 {"success": true}
     */
    public function show(Result $result)
    {
        return ApiResponse::success(
            new ResultResource(
                $result->load([
                    'enrollment',
                    'student',
                    'semester',
                    'academicSession',
                ])
            ),
            'Result retrieved successfully.'
        );
    }

    /**
     * Update Result
     *
     * Updates an existing result. Grade and grade point are recalculated automatically based on the updated marks.
     *
     * @group Result Management
     *
     * @authenticated
     *
     * @urlParam result integer required Result ID. Example: 1
     *
     * @bodyParam enrollment_id integer required Enrollment ID. Example: 1
     * @bodyParam marks number required Obtained marks (0-100). Example: 90
     * @bodyParam remarks string Optional remarks. Example: Updated after re-evaluation
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Result updated successfully."
     * }
     */
    public function update(
        UpdateResultRequest $request,
        Result $result
    ) {

        $result = $this->service->update(
            $result,
            $request->validated()
        );

        return ApiResponse::success(
            new ResultResource(
                $result->load([
                    'enrollment',
                    'student',
                    'semester',
                    'academicSession',
                ])
            ),
            'Result updated successfully.'
        );
    }

    /**
     * Delete Result
     *
     * Deletes a student's result.
     *
     * @group Result Management
     *
     * @authenticated
     *
     * @urlParam result integer required Result ID. Example: 1
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Result deleted successfully."
     * }
     */
    public function destroy(Result $result)
    {
        $this->service->destroy($result);

        return ApiResponse::deleted(
            'Result deleted successfully.'
        );
    }

    
}