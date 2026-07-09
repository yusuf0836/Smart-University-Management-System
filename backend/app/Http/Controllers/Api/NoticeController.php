<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NoticeRequest;
use App\Models\Notice;

class NoticeController extends Controller
{
    /**
     * Display all notices.
     */
    public function index()
    {
        $notices = Notice::latest()->get();

        return response()->json([
            'success' => true,
            'data' => $notices,
        ]);
    }

    /**
     * Store a newly created notice.
     */
    public function store(NoticeRequest $request)
    {
        $notice = Notice::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Notice created successfully.',
            'data' => $notice,
        ], 201);
    }

    /**
     * Display the specified notice.
     */
    public function show(Notice $notice)
    {
        return response()->json([
            'success' => true,
            'data' => $notice,
        ]);
    }

    /**
     * Update the specified notice.
     */
    public function update(NoticeRequest $request, Notice $notice)
    {
        $notice->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Notice updated successfully.',
            'data' => $notice,
        ]);
    }

    /**
     * Remove the specified notice.
     */
    public function destroy(Notice $notice)
    {
        $notice->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notice deleted successfully.',
        ]);
    }
}