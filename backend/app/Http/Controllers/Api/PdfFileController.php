<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\PdfFile;
use App\Services\FileUploadService;
use Illuminate\Http\Request;

class PdfFileController extends Controller
{
    protected FileUploadService $fileUploadService;

    public function __construct(
        FileUploadService $fileUploadService
    ) {
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * Upload PDF file.
     */
    public function upload(Request $request)
    {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'category' => [
                'nullable',
                'string',
                'max:100',
            ],

            'file' => [
                'required',
                'file',
                'mimes:pdf',
                'max:10240',
            ],
        ]);

        $uploadedFile = $validated['file'];

        $filePath = $this->fileUploadService->upload(
            $uploadedFile,
            'pdfs'
        );

        $pdfFile = PdfFile::create([
            'title' => $validated['title'],

            'file_path' => $filePath,

            'file_name' => $uploadedFile->getClientOriginalName(),

            'file_type' => $uploadedFile->getClientMimeType(),

            'file_size' => $uploadedFile->getSize(),

            'category' => $validated['category'] ?? null,

            'uploaded_by' => $request->user()->id,

            'status' => true,
        ]);

        return ApiResponse::success(
            [
                'id' => $pdfFile->id,

                'title' => $pdfFile->title,

                'file_name' => $pdfFile->file_name,

                'file_type' => $pdfFile->file_type,

                'file_size' => $pdfFile->file_size,

                'category' => $pdfFile->category,

                'file_path' => $pdfFile->file_path,

                'file_url' => $this->fileUploadService
                    ->url($pdfFile->file_path),
            ],
            'PDF uploaded successfully.'
        );
    }

    /**
     * Get all PDF files.
     */
    public function index()
    {
        $pdfFiles = PdfFile::with('uploadedBy')
            ->latest()
            ->get()
            ->map(function ($pdfFile) {
                return [
                    'id' => $pdfFile->id,
                    'title' => $pdfFile->title,
                    'file_name' => $pdfFile->file_name,
                    'file_type' => $pdfFile->file_type,
                    'file_size' => $pdfFile->file_size,
                    'category' => $pdfFile->category,
                    'status' => $pdfFile->status,
                    'file_path' => $pdfFile->file_path,
                    'file_url' => $this->fileUploadService
                        ->url($pdfFile->file_path),

                    'uploaded_by' => $pdfFile->uploadedBy
                        ? [
                            'id' => $pdfFile->uploadedBy->id,
                            'name' => $pdfFile->uploadedBy->name,
                            'email' => $pdfFile->uploadedBy->email,
                        ]
                        : null,

                    'created_at' => $pdfFile->created_at,
                ];
            });

        return ApiResponse::success(
            $pdfFiles,
            'PDF files retrieved successfully.'
        );
    }

    /**
     * Get single PDF file.
     */
    public function show(int $id)
    {
        $pdfFile = PdfFile::with('uploadedBy')
            ->findOrFail($id);

        return ApiResponse::success(
            [
                'id' => $pdfFile->id,
                'title' => $pdfFile->title,
                'file_name' => $pdfFile->file_name,
                'file_type' => $pdfFile->file_type,
                'file_size' => $pdfFile->file_size,
                'category' => $pdfFile->category,
                'status' => $pdfFile->status,
                'file_path' => $pdfFile->file_path,
                'file_url' => $this->fileUploadService
                    ->url($pdfFile->file_path),

                'uploaded_by' => $pdfFile->uploadedBy
                    ? [
                        'id' => $pdfFile->uploadedBy->id,
                        'name' => $pdfFile->uploadedBy->name,
                        'email' => $pdfFile->uploadedBy->email,
                    ]
                    : null,

                'created_at' => $pdfFile->created_at,
            ],
            'PDF file retrieved successfully.'
        );
    }

    /**
     * Delete PDF file.
     */
    public function destroy(int $id)
    {
        $pdfFile = PdfFile::findOrFail($id);

        $this->fileUploadService->delete(
            $pdfFile->file_path
        );

        $pdfFile->delete();

        return ApiResponse::success(
            null,
            'PDF file deleted successfully.'
        );
    }
}