<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Resources\DepartmentResource;
use App\Helpers\QueryFilter;
use App\Helpers\ApiResponse;

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

        return ApiResponse::success(
            DepartmentResource::collection($departments),
            'Departments retrieved successfully',
            $departments
        );
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

        return ApiResponse::created(
            new DepartmentResource($department),
            'Department created successfully'
        );
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

        return ApiResponse::success(
            new DepartmentResource($department),
            'Department retrieved successfully'
        );
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

        return ApiResponse::success(
            new DepartmentResource($department),
            'Department updated successfully'
        );
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

        return ApiResponse::deleted(
            'Department deleted successfully'
        );
    }
}