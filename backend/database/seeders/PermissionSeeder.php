<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [

            // Faculty
            'faculty.view',
            'faculty.create',
            'faculty.update',
            'faculty.delete',

            // Department
            'department.view',
            'department.create',
            'department.update',
            'department.delete',

            // Teacher
            'teacher.view',
            'teacher.create',
            'teacher.update',
            'teacher.delete',

            // Student
            'student.view',
            'student.create',
            'student.update',
            'student.delete',

            // Semester
            'semester.view',
            'semester.create',
            'semester.update',
            'semester.delete',

            // Course
            'course.view',
            'course.create',
            'course.update',
            'course.delete',

            // Enrollment
            'enrollment.view',
            'enrollment.create',
            'enrollment.update',
            'enrollment.delete',

            // Attendance
            'attendance.view',
            'attendance.create',
            'attendance.update',
            'attendance.delete',

            // Result
            'result.view',
            'result.create',
            'result.update',
            'result.delete',

            // Notice
            'notice.view',
            'notice.create',
            'notice.update',
            'notice.delete',

            // Routine
            'routine.view',
            'routine.create',
            'routine.update',
            'routine.delete',

            // Fee
            'fee.view',
            'fee.create',
            'fee.update',
            'fee.delete',

            // Examination
            'examination.view',
            'examination.create',
            'examination.update',
            'examination.delete',

            // Transcript
            'transcript.view',
            'transcript.generate',
            'transcript.download',
            'transcript.delete',

            // Dashboard
            'dashboard.view',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
            ]);
        }
    }
}