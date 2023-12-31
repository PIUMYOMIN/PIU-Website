<?php

namespace Database\Seeders;
use App\Models\User;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create(
            [
            'name' => 'superadmin',
            'email' => 'superadmin@gmail.com',
            'city' => 'Mandalay',
            'country' => 'Myanmar',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            ],
        );

        $user->assignRole('admin','admin');
        $user->givePermissionTo('Read and Write');
    }
}