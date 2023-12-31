<?php

namespace Database\Seeders;
use Spatie\Permission\Models\Permission;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Permission::create(['name' => 'Read and Write']);
        $role = Permission::create(['name' => 'Read']);
        $role = Permission::create(['name' => 'Write']);
        $role = Permission::create(['name' => 'Registrar']);
        $role = Permission::create(['name' => 'User']);
    }
}