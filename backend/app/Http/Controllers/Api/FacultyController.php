<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Faculty\StoreFacultyRequest;
use App\Http\Requests\Faculty\UpdateFacultyRequest;
use App\Http\Resources\FacultyResource;
use App\Models\Faculty;

class FacultyController extends Controller
{
    /**
     * Display a paginated list of faculties.
     */
    public function index()
    {
        $faculties = Faculty::latest()->paginate(10);

        return FacultyResource::collection($faculties);
    }

    /**
     * Store a new faculty.
     */
    public function store(StoreFacultyRequest $request)
    {
        $faculty = Faculty::create($request->validated());

        return new FacultyResource($faculty);
    }

    /**
     * Display a specific faculty.
     */
    public function show(Faculty $faculty)
    {
        return new FacultyResource($faculty);
    }

    /**
     * Update a faculty.
     */
    public function update(UpdateFacultyRequest $request, Faculty $faculty)
    {
        $faculty->update($request->validated());

        return new FacultyResource($faculty);
    }

    /**
     * Soft delete a faculty.
     */
    public function destroy(Faculty $faculty)
    {
        $faculty->delete();

        return response()->json([
            'success' => true,
            'message' => 'Faculty deleted successfully.'
        ]);
    }
}