<?php

namespace Database\Seeders;

use App\Models\Year;
use Illuminate\Database\Seeder;

class YearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Year::insert([
            [
                'name' => 'First Year',
            ],
            [
                'name' => 'Second Year',
            ],
            [
                'name' => 'Third Year',
            ],
            [
                'name' => 'Fourth Year',
            ],
        ]);
    }
}
