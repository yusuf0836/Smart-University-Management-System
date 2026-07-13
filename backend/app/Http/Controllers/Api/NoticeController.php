<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NoticeRequest;
use App\Models\Notice;
use App\Http\Resources\NoticeResource;
use Illuminate\Http\Request;
use App\Helpers\QueryFilter;
use App\Helpers\ApiResponse;

class NoticeController extends Controller
{
    
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
    public function index()
    {
        $notices = QueryFilter::apply(
            Notice::query(),
            $request,

            [
                'title'
            ],

            [
                'status'
            ],

            [
                'id',
                'title',
                'publish_date'
            ]
        );

        return ApiResponse::success(
            NoticeResource::collection($notices),
            'Notices retrieved successfully',
            $notices
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
    public function store(NoticeRequest $request)
    {
        $notice = Notice::create($request->validated());

        return ApiResponse::created(
            new NoticeResource($notice),
            'Notice created successfully'
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
    public function show(Notice $notice)
    {
        return ApiResponse::success(
            new NoticeResource($notice),
            'Notice retrieved successfully'
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
    public function update(NoticeRequest $request, Notice $notice)
    {
        $notice->update($request->validated());

        return ApiResponse::success(
            new NoticeResource($notice),
            'Notice updated successfully'
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
    public function destroy(Notice $notice)
    {
        $notice->delete();

        return ApiResponse::deleted(
            'Notice deleted successfully'
        );
    }
}