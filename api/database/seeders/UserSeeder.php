<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
            'password' => '123456',
            'role' => 2
        ]);
        User::create([
            'email' => 'user@test.com',
            'first_name' => 'User',
            'last_name' => 'User',
            'avatar' => fake()->imageUrl(360, 360),
            'password' => '1234',
            'role' => 1
        ]);
        User::factory(12)->create();
    }
}
