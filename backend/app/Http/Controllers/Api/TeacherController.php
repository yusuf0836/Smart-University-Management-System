<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeacherRequest;
use App\Models\Teacher;
use App\Http\Resources\TeacherResource;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with('department')->latest()->get();

        return response()->json([
            'success' => true,
            'data' => TeacherResource::collection($teachers),
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
        $teacher->load('department');

        return response()->json([
            'success' => true,
            'data' => new TeacherResource($teacher),
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