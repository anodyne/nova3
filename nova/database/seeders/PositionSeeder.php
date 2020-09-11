<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Nova\Departments\Models\Position;

class PositionSeeder extends Seeder
{
    public function run()
    {
        activity()->disableLogging();

        $positions = [
            ['name' => 'Commanding Officer', 'department_id' => 1, 'active' => true, 'sort' => 0],
            ['name' => 'Executive Officer', 'department_id' => 1, 'active' => true, 'sort' => 1],

            ['name' => 'Chief Flight Control Officer', 'department_id' => 2, 'active' => true, 'sort' => 0],
            ['name' => 'Flight Control Pilot', 'department_id' => 2, 'active' => true, 'sort' => 1],

            ['name' => 'Chief Operations Officer', 'department_id' => 3, 'active' => true, 'sort' => 0],
            ['name' => 'Operations Officer', 'department_id' => 3, 'active' => true, 'sort' => 1],

            ['name' => 'Chief Security/Tactical Officer', 'department_id' => 4, 'active' => true, 'sort' => 0],
            ['name' => 'Security Officer', 'department_id' => 4, 'active' => true, 'sort' => 1],
            ['name' => 'Tactical Officer', 'department_id' => 4, 'active' => true, 'sort' => 2],

            ['name' => 'Chief Engineer', 'department_id' => 5, 'active' => true, 'sort' => 0],
            ['name' => 'Assistant Chief Engineer', 'department_id' => 5, 'active' => true, 'sort' => 1],
            ['name' => 'Damage Control Specialist', 'department_id' => 5, 'active' => true, 'sort' => 2],

            ['name' => 'Chief Science Officer', 'department_id' => 6, 'active' => true, 'sort' => 0],
            ['name' => 'Scientist', 'department_id' => 6, 'active' => true, 'sort' => 1],

            ['name' => 'Chief Medical Officer', 'department_id' => 7, 'active' => true, 'sort' => 0],
            ['name' => 'Chief Surgeon', 'department_id' => 7, 'active' => true, 'sort' => 1],

            ['name' => 'Marine CO', 'department_id' => 8, 'active' => true, 'sort' => 0],
            ['name' => 'Marine XO', 'department_id' => 8, 'active' => true, 'sort' => 1],
            ['name' => 'Marine', 'department_id' => 8, 'active' => true, 'sort' => 2],
        ];

        collect($positions)->each([Position::class, 'create']);

        activity()->enableLogging();
    }
}
