<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Job;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Job::create([
            'title' => 'Program Manager',
            'description' => 'No data',
            'num_of_posts' => 5,
            'job_campus' => 'Phaung Daw Oo Monastic School',
            'expire_date' => '2024-02-15',
            'expire_time' => '09:20:00',
            'city' => 'Mandalay',
            'country' => 'Myanmar',
            'image' => 'images/test.jpg',
            'user_id' => 1
        ]);
    }
}