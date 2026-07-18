<?php

namespace App\Services;

use App\Models\Semester;
use Illuminate\Support\Facades\DB;

class SemesterService
{
    /**
     * Create Semester
     */
    public function store(array $data): Semester
    {
        return DB::transaction(function () use ($data) {

            return Semester::create($data);

        });
    }

    /**
     * Update Semester
     */
    public function update(
        Semester $semester,
        array $data
    ): Semester {

        return DB::transaction(function () use ($semester, $data) {

            $semester->update($data);

            return $semester->fresh();

        });
    }

    /**
     * Delete Semester
     */
    public function destroy(
        Semester $semester
    ): void {

        $semester->delete();

    }
}