<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use App\Services\DepartmentService;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function __construct(
        protected DepartmentService $service
    ) {}

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
        $query = Department::with('faculty');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        // Filter
        if ($request->filled('faculty_id')) {
            $query->where('faculty_id', $request->faculty_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'desc');

        $departments = $query
            ->orderBy($sortBy, $sortOrder)
            ->paginate(10);

        return ApiResponse::success(
            DepartmentResource::collection($departments),
            'Departments retrieved successfully.',
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
    public function store(StoreDepartmentRequest $request)
    {
        $department = $this->service->store(
            $request->validated()
        );

        return ApiResponse::created(
            new DepartmentResource($department),
            'Department created successfully.'
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
            'Department retrieved successfully.'
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
    public function update(
        UpdateDepartmentRequest $request,
        Department $department
    ) {
        $department = $this->service->update(
            $department,
            $request->validated()
        );

        return ApiResponse::success(
            new DepartmentResource($department),
            'Department updated successfully.'
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
        $this->service->destroy($department);

        return ApiResponse::deleted(
            'Department deleted successfully.'
        );
    }
}