<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    /**
     * Upload a file to public storage.
     */
    public function upload(
        UploadedFile $file,
        string $directory
    ): string {
        return $file->store(
            $directory,
            'public'
        );
    }

    /**
     * Delete a file from public storage.
     */
    public function delete(?string $path): bool
    {
        if (!$path) {
            return false;
        }

        if (!Storage::disk('public')->exists($path)) {
            return false;
        }

        return Storage::disk('public')->delete($path);
    }

    /**
     * Get public URL of a file.
     */
    public function url(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        return Storage::disk('public')->url($path);
    }

    /**
     * Replace an existing file.
     */
    public function replace(
        UploadedFile $file,
        string $directory,
        ?string $oldPath = null
    ): string {
        if ($oldPath) {
            $this->delete($oldPath);
        }

        return $this->upload(
            $file,
            $directory
        );
    }
}