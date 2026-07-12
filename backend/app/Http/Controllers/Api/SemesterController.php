<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SemesterRequest;
use App\Models\Semester;
use App\Http\Resources\SemesterResource;

class SemesterController extends Controller
{
    /**
     * Display all semesters.
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
     * Store a newly created semester.
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
     * Display the specified semester.
     */
    public function show(Semester $semester)
    {
        return response()->json([
            'success' => true,
            'data' => new SemesterResource($semester),
        ]);
    }

    /**
     * Update the specified semester.
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
     * Remove the specified semester.
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