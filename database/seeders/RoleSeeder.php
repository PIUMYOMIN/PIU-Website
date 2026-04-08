<?php

namespace Database\Seeders;
use Spatie\Permission\Models\Role;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::create(['name' => 'admin']);
        $role = Role::create(['name' => 'manager']);
        $role = Role::create(['name' => 'staff']);
        $role = Role::create(['name' => 'registrar']);
        $role = Role::create(['name' => 'teacher']);
        $role = Role::create(['name' => 'student']);
        $role = Role::create(['name' => 'user']);
    }
}