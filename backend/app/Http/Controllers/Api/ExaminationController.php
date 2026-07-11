<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExaminationRequest;
use App\Models\Examination;

class ExaminationController extends Controller
{
    /**
     * Display all examinations.
     */
    public function index()
    {
        $examinations = Examination::with([
            'department',
            'semester',
        ])->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $examinations,
        ]);
    }

    /**
     * Store a newly created examination.
     */
    public function store(ExaminationRequest $request)
    {
        $examination = Examination::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Examination created successfully.',
            'data' => $examination,
        ], 201);
    }

    /**
     * Display the specified examination.
     */
    public function show(Examination $examination)
    {
        return response()->json([
            'success' => true,
            'data' => $examination->load([
                'department',
                'semester',
            ]),
        ]);
    }

    /**
     * Update the specified examination.
     */
    public function update(ExaminationRequest $request, Examination $examination)
    {
        $examination->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Examination updated successfully.',
            'data' => $examination,
        ]);
    }

    /**
     * Remove the specified examination.
     */
    public function destroy(Examination $examination)
    {
        $examination->delete();

        return response()->json([
            'success' => true,
            'message' => 'Examination deleted successfully.',
        ]);
    }
}