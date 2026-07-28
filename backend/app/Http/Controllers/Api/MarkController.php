<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMarkRequest;
use App\Http\Requests\UpdateMarkRequest;
use App\Http\Resources\MarkResource;
use App\Models\Mark;
use App\Services\MarkService;
use Illuminate\Http\Request;

class MarkController extends Controller
{
    public function __construct(
        protected MarkService $service
    ) {}

    public function index(Request $request)
    {
        $marks = Mark::with([
            'student',
            'examination',
        ])
        ->latest()
        ->paginate($request->get('per_page', 10));

        return ApiResponse::success(
            MarkResource::collection($marks),
            'Mark list retrieved successfully.',
            $marks
        );
    }

    public function store(StoreMarkRequest $request)
    {
        $mark = $this->service->store(
            $request->validated()
        );

        return ApiResponse::created(
            new MarkResource(
                $mark->load([
                    'student',
                    'examination',
                ])
            ),
            'Mark created successfully.'
        );
    }

    public function show(Mark $mark)
    {
        return ApiResponse::success(
            new MarkResource(
                $mark->load([
                    'student',
                    'examination',
                ])
            ),
            'Mark retrieved successfully.'
        );
    }

    public function update(
        UpdateMarkRequest $request,
        Mark $mark
    ) {

        $mark = $this->service->update(
            $mark,
            $request->validated()
        );

        return ApiResponse::success(
            new MarkResource(
                $mark->load([
                    'student',
                    'examination',
                ])
            ),
            'Mark updated successfully.'
        );
    }

    public function destroy(Mark $mark)
    {
        $this->service->destroy($mark);

        return ApiResponse::deleted(
            'Mark deleted successfully.'
        );
    }
}