<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'role_name' => 'Employee Manager',

        ]);
        Role::create([
            'role_name' => 'Product Manager',
        ]);
        Role::create([
            'role_name' => 'Order Manager',
        ]);
    }
}
