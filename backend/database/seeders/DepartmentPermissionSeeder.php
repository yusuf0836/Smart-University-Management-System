<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Faculty;

class DepartmentPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $science = Faculty::where('name', 'Faculty of Science')->first();

        if (! $science) {
            return;
        }

        $departments = [

            [
                'faculty_id' => $science->id,
                'name' => 'Computer Science and Engineering',
                'code' => 'CSE',
                'description' => 'Department of Computer Science and Engineering',
                'status' => true,
            ],

            [
                'faculty_id' => $science->id,
                'name' => 'Software Engineering',
                'code' => 'SWE',
                'description' => 'Department of Software Engineering',
                'status' => true,
            ],

            [
                'faculty_id' => $science->id,
                'name' => 'Information Technology',
                'code' => 'IT',
                'description' => 'Department of Information Technology',
                'status' => true,
            ],

        ];

        foreach ($departments as $department) {

            Department::updateOrCreate(

                [
                    'code' => $department['code']
                ],

                $department

            );
        }
    }
}