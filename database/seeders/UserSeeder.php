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
        User::factory()->create([
            "user_name" => "User Name",
            "name" => "User",
            "phone" => "09999999999",
            "viber" => "09999999999",
            'address' => fake()->address(),
            "email" => "thantzinhtet2001@gmail.com",
            "password" => Hash::make("asdffdsa"),
        ]);

        User::factory()->count(50)->create();
    }
}
