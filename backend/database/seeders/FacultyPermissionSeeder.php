<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class FacultyPermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [

            'faculty.view',
            'faculty.create',
            'faculty.update',
            'faculty.delete',

        ];

        foreach ($permissions as $permission) {

            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'sanctum',
            ]);

        }
    }
}