<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeacherRequest;
use App\Models\Teacher;

class TeacherController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Teacher::with('department')->get()
        ]);
    }

    public function store(TeacherRequest $request)
    {
        $teacher = Teacher::create($request->validated());

        return response()->json([
            'data' => $teacher
        ], 201);
    }

    public function show(Teacher $teacher)
    {
        return response()->json([
            'data' => $teacher->load('department')
        ]);
    }

    public function update(TeacherRequest $request, Teacher $teacher)
    {
        $teacher->update($request->validated());

        return response()->json([
            'data' => $teacher
        ]);
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();

        return response()->json([
            'message' => 'Teacher deleted successfully'
        ]);
    }
}