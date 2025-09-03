<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Group;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all groups
        $groups = Group::all();

        // Sample users data
        $usersData = [
            ['name' => 'Alice Johnson', 'email' => 'alice@example.com', 'password' => 'password123'],
            ['name' => 'Bob Smith', 'email' => 'bob@example.com', 'password' => 'password123'],
            ['name' => 'Charlie Brown', 'email' => 'charlie@example.com', 'password' => 'password123'],
        ];

        foreach ($usersData as $userData) {
            // Create user
            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => Hash::make($userData['password']),
            ]);

            // Attach user to all groups (or pick specific groups as needed)
            $user->groups()->attach($groups->pluck('id')->toArray());
        }
    }
}
