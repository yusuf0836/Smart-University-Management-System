<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoUserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [

            [
                'name' => 'Admin',
                'email' => 'admin2@sums.com',
                'phone' => '01700000001',
                'employee_id' => 'EMP002',
                'role' => 'Admin',
            ],

            [
                'name' => 'Teacher',
                'email' => 'teacher@sums.com',
                'phone' => '01700000002',
                'employee_id' => 'EMP003',
                'role' => 'Teacher',
            ],

            [
                'name' => 'Student',
                'email' => 'student@sums.com',
                'phone' => '01700000003',
                'employee_id' => 'STD001',
                'role' => 'Student',
            ],

            [
                'name' => 'Accountant',
                'email' => 'accountant@sums.com',
                'phone' => '01700000004',
                'employee_id' => 'EMP004',
                'role' => 'Accountant',
            ],

            [
                'name' => 'Librarian',
                'email' => 'librarian@sums.com',
                'phone' => '01700000005',
                'employee_id' => 'EMP005',
                'role' => 'Librarian',
            ],

        ];

        foreach ($users as $data) {

            $role = $data['role'];
            unset($data['role']);

            $user = User::firstOrCreate(
                ['email' => $data['email']],
                array_merge($data, [
                    'password' => Hash::make('password'),
                    'status' => true,
                ])
            );

            $user->syncRoles([$role]);
        }
    }
}