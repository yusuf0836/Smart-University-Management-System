<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNoticeRequest;
use App\Http\Requests\UpdateNoticeRequest;
use App\Http\Resources\NoticeResource;
use App\Services\NoticeService;
use Illuminate\Http\JsonResponse;

class NoticeController extends Controller
{
    public function __construct(
        protected NoticeService $service
    ) {}
    /**
     * List Notices
     *
     * Returns a list of all published notices.
     *
     * @group Notice Management
     *
     * @authenticated
     *
     * @response 200 {"success": true}
     */
    public function index(): JsonResponse
    {
        return ApiResponse::success(

            NoticeResource::collection(
                $this->service->getAll()
            ),

            'Notices retrieved successfully.'

        );
    }

    /**
     * Create Notice
     *
     * Creates a new notice.
     *
     * @group Notice Management
     *
     * @authenticated
     *
     * @bodyParam title string required Notice title. Example: Mid Term Examination Notice
     * @bodyParam description string required Notice description. Example: The Mid Term Examination will start from 15 August 2026.
     * @bodyParam publish_date date required Publish date. Example: 2026-08-01
     * @bodyParam expiry_date date Expiry date. Must be on or after the publish date. Example: 2026-08-31
     * @bodyParam status boolean required Notice status. Example: true
     *
     * @response 201 {
     *   "success": true,
     *   "message": "Notice created successfully."
     * }
     */
    public function store(
        StoreNoticeRequest $request
    ): JsonResponse {

        return ApiResponse::created(

            new NoticeResource(

                $this->service->store(
                    $request->validated()
                )

            ),

            'Notice created successfully.'

        );
    }

    /**
     * Show Notice
     *
     * Returns details of a specific notice.
     *
     * @group Notice Management
     *
     * @authenticated
     *
     * @urlParam notice integer required Notice ID. Example: 1
     *
     * @response 200 {"success": true}
     */
    public function show(int $id): JsonResponse
    {
        return ApiResponse::success(

            new NoticeResource(

                $this->service->getById($id)

            ),

            'Notice retrieved successfully.'

        );
    }

    /**
     * Update Notice
     *
     * Updates an existing notice.
     *
     * @group Notice Management
     *
     * @authenticated
     *
     * @urlParam notice integer required Notice ID. Example: 1
     *
     * @bodyParam title string required Notice title. Example: Updated Examination Notice
     * @bodyParam description string required Notice description. Example: Examination schedule has been updated.
     * @bodyParam publish_date date required Publish date. Example: 2026-08-01
     * @bodyParam expiry_date date Expiry date. Must be on or after the publish date. Example: 2026-09-05
     * @bodyParam status boolean required Notice status. Example: true
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Notice updated successfully."
     * }
     */
    public function update(
        UpdateNoticeRequest $request,
        int $id
    ): JsonResponse {

        return ApiResponse::success(

            new NoticeResource(

                $this->service->update(
                    $id,
                    $request->validated()
                )

            ),

            'Notice updated successfully.'

        );
    }

    /**
     * Delete Notice
     *
     * Deletes a notice.
     *
     * @group Notice Management
     *
     * @authenticated
     *
     * @urlParam notice integer required Notice ID. Example: 1
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Notice deleted successfully."
     * }
     */
    public function destroy(
        int $id
    ): JsonResponse {

        $this->service->delete($id);

        return ApiResponse::success(

            null,

            'Notice deleted successfully.'

        );
    }

    public function restore(
        int $id
    ): JsonResponse {

        return ApiResponse::success(

            new NoticeResource(

                $this->service->restore($id)

            ),

            'Notice restored successfully.'

        );
    }

    public function published(): JsonResponse
    {
        return ApiResponse::success(

            NoticeResource::collection(

                $this->service->getPublished()

            ),

            'Published notices retrieved successfully.'

        );
    }

    public function pinned(): JsonResponse
    {
        return ApiResponse::success(

            NoticeResource::collection(

                $this->service->getPinned()

            ),

            'Pinned notices retrieved successfully.'

        );
    }

    public function audience(
        string $audience
    ): JsonResponse {

        return ApiResponse::success(

            NoticeResource::collection(

                $this->service->getByAudience(
                    $audience
                )

            ),

            'Audience notices retrieved successfully.'

        );
    }
}