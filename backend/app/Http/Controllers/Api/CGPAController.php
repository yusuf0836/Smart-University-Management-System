<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CGPAResource;
use App\Services\CGPAService;

class CGPAController extends Controller
{
    public function __construct(
        protected CGPAService $service
    ) {}

    public function show(int $studentId)
    {
        $cgpa = $this->service->calculate($studentId);

        return ApiResponse::success(
            new CGPAResource($cgpa),
            'CGPA retrieved successfully.'
        );
    }
}