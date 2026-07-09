<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoutineRequest;
use App\Models\Routine;

class RoutineController extends Controller
{
    /**
     * Display all routines.
     */
    public function index()
    {
        $routines = Routine::with([
            'department',
            'semester',
            'course',
            'teacher',
        ])->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $routines,
        ]);
    }

    /**
     * Store a newly created routine.
     */
    public function store(RoutineRequest $request)
    {
        $routine = Routine::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Routine created successfully.',
            'data' => $routine,
        ], 201);
    }

    /**
     * Display the specified routine.
     */
    public function show(Routine $routine)
    {
        return response()->json([
            'success' => true,
            'data' => $routine->load([
                'department',
                'semester',
                'course',
                'teacher',
            ]),
        ]);
    }

    /**
     * Update the specified routine.
     */
    public function update(RoutineRequest $request, Routine $routine)
    {
        $routine->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Routine updated successfully.',
            'data' => $routine,
        ]);
    }

    /**
     * Remove the specified routine.
     */
    public function destroy(Routine $routine)
    {
        $routine->delete();

        return response()->json([
            'success' => true,
            'message' => 'Routine deleted successfully.',
        ]);
    }
}