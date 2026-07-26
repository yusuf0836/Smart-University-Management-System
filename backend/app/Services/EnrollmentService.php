<?php

namespace App\Services;

use App\Models\Enrollment;

class EnrollmentService
{
    /**
     * Create Enrollment
     */
    public function store(array $data): Enrollment
    {
        return Enrollment::create($data);
    }

    /**
     * Update Enrollment
     */
    public function update(
        Enrollment $enrollment,
        array $data
    ): Enrollment {

        $enrollment->update($data);

        return $enrollment->fresh();
    }

    /**
     * Delete Enrollment
     */
    public function destroy(
        Enrollment $enrollment
    ): void {

        $enrollment->delete();
    }
}