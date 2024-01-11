<?php

namespace Database\Seeders;
use App\Models\Seminar;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeminarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Seminar::create([
            'name' => 'Test Seminar',
            'slug' => 'test-seminar',
            'description' => 'This is testing',
            'date' => '2024-01-12',
            'start_time' => '09:00 AM',
            'end_time' => '10:00 AM',
            'location' => 'PIU, Mudita Hall',
            'seat' => '150',
            'city' => 'Mandalay',
            'country' => 'Myanmar',
            'image' => '',
            'user_id' => 1,
        ]);
    }
}