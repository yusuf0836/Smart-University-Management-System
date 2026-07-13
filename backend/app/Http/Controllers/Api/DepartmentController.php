<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Resources\DepartmentResource;
use App\Helpers\QueryFilter;

class DepartmentController extends Controller
{

    /**
     * List Departments
     *
     * Returns a list of all departments with faculty information.
     *
     * @group Department Management
     *
     * @authenticated
     *
     * @response 200 {"success": true}
     */
    public function index(Request $request)
    {
        $departments = QueryFilter::apply(
            Department::query(),
            $request,

            [
                'name',
                'code'
            ],

            [
                'faculty_id',
                'status'
            ],

            [
                'id',
                'name',
                'code',
                'created_at'
            ]
        );

        return response()->json([
            'success' => true,
            'data' => DepartmentResource::collection($departments),
            'meta' => [
                'current_page' => $departments->currentPage(),
                'last_page' => $departments->lastPage(),
                'per_page' => $departments->perPage(),
                'total' => $departments->total(),
            ],
        ]);
    }

    /**
     * Create Department
     *
     * Creates a new department.
     *
     * @group Department Management
     *
     * @authenticated
     *
     * @bodyParam faculty_id integer required Faculty ID. Example: 1
     * @bodyParam department_name string required Department Name. Example: Computer Science and Engineering
     * @bodyParam department_code string required Department Code. Example: CSE
     *
     * @response 201 {"success": true}
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'faculty_id' => 'required|exists:faculties,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:departments,code',
            'description' => 'nullable|string',
            'status' => 'boolean',
        ]);

        $department = Department::create($validated);

        return response()->json([
            'data' => $department
        ], 201);
    }

    /**
     * Show Department
     *
     * Returns details of a specific department.
     *
     * @group Department Management
     *
     * @authenticated
     *
     * @urlParam department integer required Department ID. Example: 1
     *
     * @response 200 {"success": true}
     */
    public function show(Department $department)
    {
        $department->load('faculty');

        return response()->json([
            'success' => true,
            'data' => new DepartmentResource($department),
        ]);
    }

    /**
     * Update Department
     *
     * Updates an existing department.
     *
     * @group Department Management
     *
     * @authenticated
     *
     * @urlParam department integer required Department ID. Example: 1
     *
     * @response 200 {"success": true}
     */
    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'faculty_id' => 'required|exists:faculties,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:departments,code,' . $department->id,
            'description' => 'nullable|string',
            'status' => 'boolean',
        ]);

        $department->update($validated);

        return response()->json([
            'data' => $department
        ]);
    }

    /**
     * Delete Department
     *
     * Deletes a department.
     *
     * @group Department Management
     *
     * @authenticated
     *
     * @urlParam department integer required Department ID. Example: 1
     *
     * @response 200 {"success": true}
     */
    public function destroy(Department $department)
    {
        $department->delete();

        return response()->json([
            'message' => 'Department deleted successfully'
        ]);
    }
}