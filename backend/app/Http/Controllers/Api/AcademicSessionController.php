<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAcademicSessionRequest;
use App\Http\Requests\UpdateAcademicSessionRequest;
use App\Http\Resources\AcademicSessionResource;
use App\Models\AcademicSession;
use App\Services\AcademicSessionService;
use Illuminate\Validation\ValidationException;

class AcademicSessionController extends Controller
{
    public function __construct(
        protected AcademicSessionService $service
    ) {}

    /**
     * Display a listing.
     */
    public function index()
    {
        $sessions = AcademicSession::latest()->paginate(10);

        return ApiResponse::success(

        AcademicSessionResource::collection($sessions),

        'Academic sessions retrieved successfully.',

        $sessions

        );
    }

    /**
     * Store a newly created resource.
     */
    public function store(StoreAcademicSessionRequest $request)
    {
        
        $session = $this->service->store(
            $request->validated()
        );

        return ApiResponse::success(
            new AcademicSessionResource($session),
            'Academic session created successfully.',
            null,
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(AcademicSession $academicSession)
    {
        return ApiResponse::success(
            new AcademicSessionResource($academicSession),
            'Academic session retrieved successfully.'
        );
    }

    /**
     * Update the specified resource.
     */
    public function update(
        UpdateAcademicSessionRequest $request,
        AcademicSession $academicSession
    ) {
        $session = $this->service->update(
            $academicSession,
            $request->validated()
        );

        return ApiResponse::success(
            new AcademicSessionResource($session),
            'Academic session updated successfully.'
        );
    }

    /**
     * Remove the specified resource.
     */
    public function destroy(AcademicSession $academicSession)
    {
        $this->service->destroy($academicSession);

        return ApiResponse::success(
            null,
            'Academic session deleted successfully.'
        );
    }
}