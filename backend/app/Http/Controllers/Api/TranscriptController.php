<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transcript;
use App\Services\TranscriptService;
use Illuminate\Http\Request;

class TranscriptController extends Controller
{
    protected TranscriptService $transcriptService;

    public function __construct(TranscriptService $transcriptService)
    {
        $this->transcriptService = $transcriptService;
    }

    /**
     * Generate Transcript
     */
    public function generate(Request $request)
    {
        $validated = $request->validate([
            'student_id'  => 'required|exists:students,id',
            'semester_id' => 'required|exists:semesters,id',
        ]);

        $transcript = $this->transcriptService->generate(
            $validated['student_id'],
            $validated['semester_id']
        );

        return response()->json([
            'success' => true,
            'message' => 'Transcript generated successfully.',
            'data' => $transcript->load([
                'student',
                'semester',
            ]),
        ]);
    }

    /**
     * Show Transcript
     */
    public function show(Transcript $transcript)
    {
        return response()->json([
            'success' => true,
            'data' => $transcript->load([
                'student',
                'semester',
            ]),
        ]);
    }

    /**
     * List all Transcripts
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Transcript::with([
                'student',
                'semester',
            ])->latest()->get(),
        ]);
    }

    /**
     * Delete Transcript
     */
    public function destroy(Transcript $transcript)
    {
        $transcript->delete();

        return response()->json([
            'success' => true,
            'message' => 'Transcript deleted successfully.',
        ]);
    }
}