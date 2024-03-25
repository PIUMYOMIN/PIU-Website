<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Subject::create(
            [
                "name" => "First Subject",
                "description" => "Testing",
                "course_id" => 1,
                "module_id" => 1,
                "user_id" => 1,
            ]
        );
    }
}