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

        foreach ($usersData as $index => $userData) {
            // Create user
            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => Hash::make($userData['password']),
            ]);

            // Attach user to groups with roles
            foreach ($groups as $group) {
                // Assign roles differently based on user & group (example)
                // Customize this logic as needed
                $role = 'member';

                if ($index === 0 && $group->id === $groups->first()->id) {
                    $role = 'chair';  // Alice is chair in first group
                } elseif ($index === 1 && $group->id === $groups->first()->id) {
                    $role = 'secretary';  // Bob is secretary in first group
                } elseif ($index === 2 && $group->id === $groups->first()->id) {
                    $role = 'treasurer';  // Charlie is treasurer in first group
                }

                // Attach user to group with role
                $user->groups()->attach($group->id, ['role' => $role]);
            }
        }
    }
}
