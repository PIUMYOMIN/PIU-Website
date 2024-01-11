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
                'name' => 'PIU Management Team',
                'description' => '',
                'created_at' => now(),
            ],
            [
                'name' => 'PIU Division of Academic Affairs',
                'description' => '',
                'created_at' => now(),
            ],
            [
                'name' => 'PIU Student Affairs',
                'description' => '',
                'created_at' => now(),
            ],
            [
                'name' => 'PIU School of Education',
                'description' => '',
                'created_at' => now(),
            ],
            [
                'name' => 'PIU School of Foreign Languages',
                'description' => '',
                'created_at' => now(),
            ],
        ]);
    }
}