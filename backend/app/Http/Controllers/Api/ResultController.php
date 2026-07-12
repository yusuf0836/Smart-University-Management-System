<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResultRequest;
use App\Models\Result;
use App\Http\Resources\ResultResource;

class ResultController extends Controller
{
    
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
    public function index()
    {
        $results = Result::with([
            'enrollment.student',
            'enrollment.course',
            'enrollment.semester',
        ])->latest()->get();

        return response()->json([
            'success' => true,
            'data' => ResultResource::collection($results),
        ]);
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
    public function store(ResultRequest $request)
    {
        $data = $request->validated();

        [$grade, $gradePoint] = $this->calculateGrade($data['marks']);

        $data['grade'] = $grade;
        $data['grade_point'] = $gradePoint;

        $result = Result::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Result created successfully.',
            'data' => $result,
        ], 201);
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
        $result->load([
            'enrollment.student',
            'enrollment.course',
            'enrollment.semester',
        ]);

        return response()->json([
            'success' => true,
            'data' => new ResultResource($result),
        ]);
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
    public function update(ResultRequest $request, Result $result)
    {
        $data = $request->validated();

        [$grade, $gradePoint] = $this->calculateGrade($data['marks']);

        $data['grade'] = $grade;
        $data['grade_point'] = $gradePoint;

        $result->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Result updated successfully.',
            'data' => $result,
        ]);
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
        $result->delete();

        return response()->json([
            'success' => true,
            'message' => 'Result deleted successfully.',
        ]);
    }

    /**
     * Calculate grade and grade point.
     */
    private function calculateGrade($marks): array
    {
        if ($marks >= 80) return ['A+', 4.00];
        if ($marks >= 75) return ['A', 3.75];
        if ($marks >= 70) return ['A-', 3.50];
        if ($marks >= 65) return ['B+', 3.25];
        if ($marks >= 60) return ['B', 3.00];
        if ($marks >= 55) return ['B-', 2.75];
        if ($marks >= 50) return ['C+', 2.50];
        if ($marks >= 45) return ['C', 2.25];
        if ($marks >= 40) return ['D', 2.00];

        return ['F', 0.00];
    }
}