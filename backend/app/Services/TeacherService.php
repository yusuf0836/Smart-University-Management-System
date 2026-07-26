<?php

namespace App\Services;

use App\Models\Teacher;

class TeacherService
{
    /**
     * Create Teacher
     */
    public function store(array $data): Teacher
    {
        return Teacher::create($data);
    }

    /**
     * Update Teacher
     */
    public function update(
        Teacher $teacher,
        array $data
    ): Teacher {

        $teacher->update($data);

        return $teacher->fresh();
    }

    /**
     * Delete Teacher
     */
    public function destroy(
        Teacher $teacher
    ): void {

        $teacher->delete();
    }
}