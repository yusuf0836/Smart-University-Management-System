<?php

namespace App\Services;

use App\Models\Attendance;

class AttendanceService
{
    /**
     * Store Attendance
     */
    public function store(array $data): Attendance
    {
        return Attendance::create($data);
    }

    /**
     * Update Attendance
     */
    public function update(
        Attendance $attendance,
        array $data
    ): Attendance {

        $attendance->update($data);

        return $attendance->fresh();
    }

    /**
     * Delete Attendance
     */
    public function destroy(
        Attendance $attendance
    ): bool {

        return $attendance->delete();
    }
}