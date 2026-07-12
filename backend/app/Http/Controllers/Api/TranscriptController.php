<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transcript;
use App\Services\TranscriptService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Result;
use App\Resources\TranscriptResource;

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
            'data' => new TranscriptResource([
                'student' => $student,
                'semester' => $semester,
                'results' => $results,
                'semester_gpa' => $semesterGpa,
                'cgpa' => $cgpa,
                'total_credit_completed' => $credits,
                'total_courses' => $results->count(),
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
     * Download Transcript as PDF
     */
    public function downloadPdf(Transcript $transcript)
    {
        $student = $transcript->student;
        $semester = $transcript->semester;

        $results = Result::with('enrollment.course')
            ->whereHas('enrollment', function ($query) use ($student, $semester) {
                $query->where('student_id', $student->id)
                    ->where('semester_id', $semester->id);
            })
            ->get();

        $pdf = Pdf::loadView('transcripts.pdf', [
            'transcript' => $transcript,
            'student' => $student,
            'semester' => $semester,
            'results' => $results,
        ]);

        return $pdf->download(
            'Transcript_'.$student->student_id.'_'.$semester->name.'.pdf'
        );
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