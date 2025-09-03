<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Group;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Example groups
        Group::create([
            'name' => 'Health Welfare Group',
            'description' => 'Supports health-related benefits',
            // 'code' will be auto-generated in the model
        ]);

        Group::create([
            'name' => 'Education Welfare Group',
            'description' => 'Supports education-related benefits',
        ]);

        Group::create([
            'name' => 'Community Welfare Group',
            'description' => 'General community support welfare',
        ]);
    }
}
