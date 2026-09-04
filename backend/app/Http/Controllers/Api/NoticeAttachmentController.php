<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Notice;
use App\Services\FileUploadService;
use Illuminate\Http\Request;

class NoticeAttachmentController extends Controller
{
    protected FileUploadService $fileUploadService;

    public function __construct(
        FileUploadService $fileUploadService
    ) {
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * Get notice attachment
     */
    public function show(int $noticeId)
    {
        $notice = Notice::findOrFail($noticeId);

        return ApiResponse::success(
            [
                'notice_id' => $notice->id,

                'attachment' => $notice->attachment,

                'attachment_url' => $this->fileUploadService
                    ->url($notice->attachment),
            ],
            'Notice attachment retrieved successfully.'
        );
    }

    /**
     * Upload or replace notice attachment
     */
    public function upload(
        Request $request,
        int $noticeId
    ) {
        $validated = $request->validate([
            'attachment' => [
                'required',
                'file',
                'mimes:pdf,doc,docx,jpg,jpeg,png',
                'max:5120',
            ],
        ]);

        $notice = Notice::findOrFail($noticeId);

        $attachmentPath = $this->fileUploadService->replace(
            $validated['attachment'],
            'notices/attachments',
            $notice->attachment
        );

        $notice->update([
            'attachment' => $attachmentPath,
        ]);

        return ApiResponse::success(
            [
                'notice_id' => $notice->id,

                'attachment' => $notice->attachment,

                'attachment_url' => $this->fileUploadService
                    ->url($notice->attachment),
            ],
            'Notice attachment uploaded successfully.'
        );
    }

    /**
     * Delete notice attachment
     */
    public function destroy(int $noticeId)
    {
        $notice = Notice::findOrFail($noticeId);

        if (!$notice->attachment) {
            return ApiResponse::error(
                'Notice attachment not found.',
                404
            );
        }

        $this->fileUploadService->delete(
            $notice->attachment
        );

        $notice->update([
            'attachment' => null,
        ]);

        return ApiResponse::success(
            null,
            'Notice attachment deleted successfully.'
        );
    }
}