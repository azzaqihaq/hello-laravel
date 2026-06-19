<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminRole = UserRole::create([
            'name' => 'Administrator',
            'slug' => 'administrator',
        ]);

        UserRole::create([
            'name' => 'Editor',
            'slug' => 'editor',
        ]);

        UserRole::create([
            'name' => 'User',
            'slug' => 'user',
        ]);

        User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'user_role_id' => $adminRole->id,
            'is_active' => true,
        ]);
    }
}
