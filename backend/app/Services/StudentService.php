<?php

namespace App\Services;

use App\Models\Student;

class StudentService
{
    /**
     * Store Student
     */
    public function store(array $data): Student
    {
        return Student::create($data);
    }

    /**
     * Update Student
     */
    public function update(Student $student, array $data): Student
    {
        $student->update($data);

        return $student->fresh();
    }

    /**
     * Delete Student
     */
    public function destroy(Student $student): void
    {
        $student->delete();
    }
}