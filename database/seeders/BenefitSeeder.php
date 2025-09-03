<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Benefit;
use App\Models\Group;

class BenefitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch all groups to assign benefits to each
        $groups = Group::all();

        foreach ($groups as $group) {
            Benefit::create([
                'group_id' => $group->id,
                'name' => 'Childbirth',
                'default_amount' => 10000.00,
            ]);

            Benefit::create([
                'group_id' => $group->id,
                'name' => 'Death',
                'default_amount' => 20000.00,
            ]);

            Benefit::create([
                'group_id' => $group->id,
                'name' => 'Marriage',
                'default_amount' => 15000.00,
            ]);
        }
    }
}
