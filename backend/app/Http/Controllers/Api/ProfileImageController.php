<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\FileUploadService;
use Illuminate\Http\Request;

class ProfileImageController extends Controller
{
    protected FileUploadService $fileUploadService;

    public function __construct(
        FileUploadService $fileUploadService
    ) {
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * Get authenticated user's profile image
     */
    public function show(Request $request)
    {
        $user = $request->user();

        return ApiResponse::success(
            [
                'user_id' => $user->id,

                'profile_image' => $user->profile_image,

                'profile_image_url' => $this->fileUploadService
                    ->url($user->profile_image),
            ],
            'Profile image retrieved successfully.'
        );
    }

    /**
     * Upload or replace profile image
     */
    public function upload(Request $request)
    {
        $validated = $request->validate([
            'profile_image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        $user = $request->user();

        $imagePath = $this->fileUploadService->replace(
            $validated['profile_image'],
            'profiles/images',
            $user->profile_image
        );

        $user->update([
            'profile_image' => $imagePath,
        ]);

        return ApiResponse::success(
            [
                'user_id' => $user->id,

                'profile_image' => $user->profile_image,

                'profile_image_url' => $this->fileUploadService
                    ->url($user->profile_image),
            ],
            'Profile image uploaded successfully.'
        );
    }

    /**
     * Delete authenticated user's profile image
     */
    public function destroy(Request $request)
    {
        $user = $request->user();

        if (!$user->profile_image) {
            return ApiResponse::error(
                'Profile image not found.',
                404
            );
        }

        $this->fileUploadService->delete(
            $user->profile_image
        );

        $user->update([
            'profile_image' => null,
        ]);

        return ApiResponse::success(
            null,
            'Profile image deleted successfully.'
        );
    }
}