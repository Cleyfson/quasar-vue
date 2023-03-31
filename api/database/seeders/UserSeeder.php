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
        User::create([
            'email' => 'admin@test.com',
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'avatar' => fake()->imageUrl(360, 360),
            'password' => Hash::make('123456'),
            'role' => 3
        ]);
        User::create([
            'email' => 'user@test.com',
            'first_name' => 'User',
            'last_name' => 'User',
            'avatar' => fake()->imageUrl(360, 360),
            'password' => Hash::make('1234'),
            'role' => 2
        ]);
        User::factory(12)->create();
    }
}
