<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Position;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Position::insert(
            [
                [
                    'name' => 'Professor',
                    'description' => 'no data',
                    'created_at' => now(),
                ],
                [
                    'name' => 'Assistance Professor',
                    'description' => 'no data',
                    'created_at' => now(),
                ]
            ]
        );
    }
}