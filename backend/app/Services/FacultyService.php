<?php

namespace App\Services;

use App\Models\Faculty;
use Illuminate\Support\Facades\DB;

class FacultyService
{
    /**
     * Store Faculty
     */
    public function store(array $data): Faculty
    {
        return DB::transaction(function () use ($data) {

            return Faculty::create($data);

        });
    }

    /**
     * Update Faculty
     */
    public function update(
        Faculty $faculty,
        array $data
    ): Faculty {

        return DB::transaction(function () use ($faculty, $data) {

            $faculty->update($data);

            return $faculty->fresh();

        });
    }

    /**
     * Delete Faculty
     */
    public function destroy(
        Faculty $faculty
    ): void {

        $faculty->delete();

    }
}