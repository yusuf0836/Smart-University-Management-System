<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transcript;
use App\Services\TranscriptService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Result;
use App\Http\Resources\TranscriptResource;
use App\Helpers\QueryFilter;
use App\Helpers\ApiResponse;

class TranscriptController extends Controller
{
    protected TranscriptService $transcriptService;

    public function __construct(TranscriptService $transcriptService)
    {
        $this->transcriptService = $transcriptService;
    }

    /**
     * Generate Transcript
     *
     * Generates a transcript for a student in a specific semester, including GPA, CGPA, completed credits and course results.
     *
     * @group Transcript Management
     *
     * @authenticated
     *
     * @bodyParam student_id integer required Student ID. Example: 1
     * @bodyParam semester_id integer required Semester ID. Example: 2
     *
     * @response 200 {
     *   "success": true,
     *   "data": {
     *     "semester_gpa": 3.85,
     *     "cgpa": 3.76,
     *     "total_credit_completed": 18,
     *     "total_courses": 6
     *   }
     * }
     */
    public function generate(Request $request)
    {
        $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'semester_id' => ['required', 'exists:semesters,id'],
        ]);

        $transcript = $this->transcriptService->generate(
            $request->student_id,
            $request->semester_id
        );

        $transcript->load([
            'student',
            'semester'
        ]);

        return ApiResponse::success(
            new TranscriptResource($transcript),
            'Transcript generated successfully.'
        );
    }

    /**
     * Show Transcript
     *
     * Returns details of a specific transcript.
     *
     * @group Transcript Management
     *
     * @authenticated
     *
     * @urlParam transcript integer required Transcript ID. Example: 1
     *
     * @response 200 {"success": true}
     */
    public function show(Transcript $transcript)
    {
        $transcript->load([
            'student',
            'semester'
        ]);

        return ApiResponse::success(
            new TranscriptResource($transcript),
            'Transcript retrieved successfully'
        );
    }

    /**
     * List Transcripts
     *
     * Returns a list of all generated transcripts with student and semester information.
     *
     * @group Transcript Management
     *
     * @authenticated
     *
     * @response 200 {"success": true}
     */
    public function index(Request $request)
    {
        $transcripts = QueryFilter::apply(
            Transcript::with([
                'student',
                'semester'
            ]),
            $request,

            [],

            [
                'student_id',
                'semester_id',
                'status'
            ],

            [
                'id',
                'semester_gpa',
                'cgpa',
                'created_at'
            ]
        );

        return ApiResponse::success(
            TranscriptResource::collection($transcripts),
            'Transcripts retrieved successfully',
            $transcripts
        );
    }
    
    /**
     * Download Transcript PDF
     *
     * Downloads the transcript as a PDF document.
     *
     * @group Transcript Management
     *
     * @authenticated
     *
     * @urlParam transcript integer required Transcript ID. Example: 1
     *
     * @response 200
     */
    public function downloadPdf(Transcript $transcript)
    {
        $transcript->load([
            'student',
            'semester'
        ]);
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
     *
     * Deletes a transcript.
     *
     * @group Transcript Management
     *
     * @authenticated
     *
     * @urlParam transcript integer required Transcript ID. Example: 1
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Transcript deleted successfully."
     * }
     */
    public function destroy(Transcript $transcript)
    {
        $transcript->delete();

        return ApiResponse::deleted(
            'Transcript deleted successfully'
        );
    }
}