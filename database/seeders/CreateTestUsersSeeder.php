<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateTestUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => "John Doe",
            'email' => "john@test.com",
            'password' => Hash::make("zero2Hero@1"),
        ]);

        User::create([
            'name' => "Jane Doe",
            'email' => "jane@test.com",
            'password' => Hash::make("zero2Hero@1"),
        ]);
    }
}
