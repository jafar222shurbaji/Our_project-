<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Employee::create([
            'name' => 'Employee Manager',
            'email' => 'employee@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => 1,
        ]);
        Employee::create([
            'name' => 'jad Manager',
            'email' => 'jad@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => 1,
        ]);
        Employee::create([
            'name' => 'Product Manager',
            'email' => 'product@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => 2,
        ]);
        Employee::create([
            'name' => 'Order Manager',
            'email' => 'order@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => 3,
        ]);

    }
}
