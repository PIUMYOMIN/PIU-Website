<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Assignment;

class AssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Assignment::insert([
            [
                'name' => 'First Assignmet',
                'description' => '',
                'attach_file' => 'test/test.pdf',
                'module_id' => 1,
                'course_id' => 1,
                'user_id' => 1,
            ]
        ]);
    }
}