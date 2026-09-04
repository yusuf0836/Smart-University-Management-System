<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Services\FileUploadService;
use Illuminate\Http\Request;

class TeacherPhotoController extends Controller
{
    protected FileUploadService $fileUploadService;

    public function __construct(
        FileUploadService $fileUploadService
    ) {
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * Get teacher photo
     */
    public function show(int $teacherId)
    {
        $teacher = Teacher::findOrFail($teacherId);

        return ApiResponse::success(
            [
                'teacher_id' => $teacher->id,

                'photo' => $teacher->photo,

                'photo_url' => $this->fileUploadService
                    ->url($teacher->photo),
            ],
            'Teacher photo retrieved successfully.'
        );
    }

    /**
     * Upload or replace teacher photo
     */
    public function upload(
        Request $request,
        int $teacherId
    ) {
        $validated = $request->validate([
            'photo' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        $teacher = Teacher::findOrFail($teacherId);

        $photoPath = $this->fileUploadService->replace(
            $validated['photo'],
            'teachers/photos',
            $teacher->photo
        );

        $teacher->update([
            'photo' => $photoPath,
        ]);

        return ApiResponse::success(
            [
                'teacher_id' => $teacher->id,

                'photo' => $teacher->photo,

                'photo_url' => $this->fileUploadService
                    ->url($teacher->photo),
            ],
            'Teacher photo uploaded successfully.'
        );
    }

    /**
     * Delete teacher photo
     */
    public function destroy(int $teacherId)
    {
        $teacher = Teacher::findOrFail($teacherId);

        if (!$teacher->photo) {
            return ApiResponse::error(
                'Teacher photo not found.',
                404
            );
        }

        $this->fileUploadService->delete(
            $teacher->photo
        );

        $teacher->update([
            'photo' => null,
        ]);

        return ApiResponse::success(
            null,
            'Teacher photo deleted successfully.'
        );
    }
}