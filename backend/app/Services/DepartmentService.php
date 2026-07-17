<?php

namespace App\Services;

use App\Models\Department;
use Illuminate\Support\Facades\DB;

class DepartmentService
{
    /**
     * Create Department
     */
    public function store(array $data): Department
    {
        return DB::transaction(function () use ($data) {

            return Department::create($data);

        });
    }

    /**
     * Update Department
     */
    public function update(
        Department $department,
        array $data
    ): Department {

        return DB::transaction(function () use ($department, $data) {

            $department->update($data);

            return $department->fresh();

        });
    }

    /**
     * Delete Department
     */
    public function destroy(
        Department $department
    ): void {

        $department->delete();

    }
}