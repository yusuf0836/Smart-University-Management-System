<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResultRequest;
use App\Models\Result;
use App\Http\Resources\ResultResource;

class ResultController extends Controller
{
    /**
     * Display all results.
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
     * Store a newly created result.
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
     * Display the specified result.
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
     * Update the specified result.
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
     * Remove the specified result.
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