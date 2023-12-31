<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CourseCategory;

class CourseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CourseCategory::Insert([
            [
                'name' => 'Master Degree',
                'description' => '',
                'user_id' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Post-graduate',
                'description' => '',
                'user_id' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Bachelor Degree',
                'description' => '',
                'user_id' => 1,
                'created_at' => now(),
            ],
        ]);
    }
}