<?php

namespace App\Services;

use App\Models\TeacherCourseAssignment;

class TeacherCourseAssignmentService
{
    /**
     * Create Assignment
     */
    public function store(array $data): TeacherCourseAssignment
    {
        return TeacherCourseAssignment::create($data);
    }

    /**
     * Update Assignment
     */
    public function update(
        TeacherCourseAssignment $assignment,
        array $data
    ): TeacherCourseAssignment {

        $assignment->update($data);

        return $assignment->fresh();
    }

    /**
     * Delete Assignment
     */
    public function destroy(
        TeacherCourseAssignment $assignment
    ): void {

        $assignment->delete();
    }
}