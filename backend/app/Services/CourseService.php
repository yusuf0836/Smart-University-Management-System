<?php

namespace App\Services;

use App\Models\Course;

class CourseService
{
    public function store(array $data): Course
    {
        return Course::create($data);
    }

    public function update(
        Course $course,
        array $data
    ): Course {

        $course->update($data);

        return $course->fresh();
    }

    public function destroy(
        Course $course
    ): void {

        $course->delete();

    }
}