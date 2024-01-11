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
                'name' => 'Ph.D Degree Course',
                'description' => '',
                'user_id' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Master Degree Course',
                'description' => '',
                'user_id' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Bachelor Degree Course',
                'description' => '',
                'user_id' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Diploma Degree Course',
                'description' => '',
                'user_id' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Short Course',
                'description' => '',
                'user_id' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Other',
                'description' => '',
                'user_id' => 1,
                'created_at' => now(),
            ],
        ]);
    }
}