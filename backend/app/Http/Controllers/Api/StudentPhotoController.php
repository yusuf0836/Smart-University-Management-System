<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Services\FileUploadService;
use Illuminate\Http\Request;

class StudentPhotoController extends Controller
{
    protected FileUploadService $fileUploadService;

    public function __construct(
        FileUploadService $fileUploadService
    ) {
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * Get student photo
     */
    public function show(int $studentId)
    {
        $student = Student::findOrFail($studentId);

        return ApiResponse::success(
            [
                'student_id' => $student->id,

                'photo' => $student->photo,

                'photo_url' => $this->fileUploadService
                    ->url($student->photo),
            ],
            'Student photo retrieved successfully.'
        );
    }

    /**
     * Upload or replace student photo
     */
    public function upload(
        Request $request,
        int $studentId
    ) {
        $validated = $request->validate([
            'photo' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        $student = Student::findOrFail($studentId);

        $photoPath = $this->fileUploadService->replace(
            $validated['photo'],
            'students/photos',
            $student->photo
        );

        $student->update([
            'photo' => $photoPath,
        ]);

        return ApiResponse::success(
            [
                'student_id' => $student->id,

                'photo' => $student->photo,

                'photo_url' => $this->fileUploadService
                    ->url($student->photo),
            ],
            'Student photo uploaded successfully.'
        );
    }

    /**
     * Delete student photo
     */
    public function destroy(int $studentId)
    {
        $student = Student::findOrFail($studentId);

        if (!$student->photo) {
            return ApiResponse::error(
                'Student photo not found.',
                404
            );
        }

        $this->fileUploadService->delete(
            $student->photo
        );

        $student->update([
            'photo' => null,
        ]);

        return ApiResponse::success(
            null,
            'Student photo deleted successfully.'
        );
    }
}