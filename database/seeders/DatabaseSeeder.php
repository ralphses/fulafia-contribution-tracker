<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Utils\Utils;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->count(10)->create(); // Random roles

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@fulafia-contribute.com',
            'role' => Utils::ROLE_ADMIN,
        ]);

        User::factory()->create([
            'name' => 'Staff User',
            'email' => 'staff@fulafia-contribute.com',
            'role' => Utils::ROLE_STAFF,
        ]);

        User::factory()->create([
            'name' => 'Student User',
            'email' => 'student@fulafia-contribute.com',
            'role' => Utils::ROLE_STUDENT,
        ]);
    }
}
