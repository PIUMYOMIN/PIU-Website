<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::insert([
            [
                'name' => 'Department of University of Admission',
                'description' => '',
                'created_at' => now(),
            ],
            [
                'name' => 'Department of University of Student Affairs',
                'description' => '',
                'created_at' => now(),
            ],
        ]);
    }
}