<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeeRequest;
use App\Models\Fee;

class FeeController extends Controller
{
    /**
     * Display all fees.
     */
    public function index()
    {
        $fees = Fee::with([
            'student',
            'semester',
        ])->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $fees,
        ]);
    }

    /**
     * Store a newly created fee.
     */
    public function store(FeeRequest $request)
    {
        $fee = Fee::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Fee created successfully.',
            'data' => $fee,
        ], 201);
    }

    /**
     * Display the specified fee.
     */
    public function show(Fee $fee)
    {
        return response()->json([
            'success' => true,
            'data' => $fee->load([
                'student',
                'semester',
            ]),
        ]);
    }

    /**
     * Update the specified fee.
     */
    public function update(FeeRequest $request, Fee $fee)
    {
        $fee->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Fee updated successfully.',
            'data' => $fee,
        ]);
    }

    /**
     * Remove the specified fee.
     */
    public function destroy(Fee $fee)
    {
        $fee->delete();

        return response()->json([
            'success' => true,
            'message' => 'Fee deleted successfully.',
        ]);
    }
}