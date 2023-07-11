<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Nova\Departments\Enums\PositionStatus;
use Nova\Departments\Models\Position;

class PositionSeeder extends Seeder
{
    public function run()
    {
        activity()->disableLogging();

        $positions = [
            ['name' => 'Commanding Officer', 'department_id' => 1, 'status' => PositionStatus::active, 'order_column' => 0],
            ['name' => 'Executive Officer', 'department_id' => 1, 'status' => PositionStatus::active, 'order_column' => 1],
            ['name' => 'Second Officer', 'department_id' => 1, 'status' => PositionStatus::active, 'order_column' => 2],

            ['name' => 'Chief Flight Control Officer', 'department_id' => 2, 'status' => PositionStatus::active, 'order_column' => 0],
            ['name' => 'Flight Control Pilot', 'department_id' => 2, 'status' => PositionStatus::active, 'order_column' => 1],

            ['name' => 'Chief Operations Officer', 'department_id' => 3, 'status' => PositionStatus::active, 'order_column' => 0],
            ['name' => 'Operations Officer', 'department_id' => 3, 'status' => PositionStatus::active, 'order_column' => 1],

            ['name' => 'Chief Security/Tactical Officer', 'department_id' => 4, 'status' => PositionStatus::active, 'order_column' => 0],
            ['name' => 'Security Officer', 'department_id' => 4, 'status' => PositionStatus::active, 'order_column' => 1],
            ['name' => 'Tactical Officer', 'department_id' => 4, 'status' => PositionStatus::active, 'order_column' => 2],

            ['name' => 'Chief Engineer', 'department_id' => 5, 'status' => PositionStatus::active, 'order_column' => 0],
            ['name' => 'Assistant Chief Engineer', 'department_id' => 5, 'status' => PositionStatus::active, 'order_column' => 1],
            ['name' => 'Engineer', 'department_id' => 5, 'status' => PositionStatus::active, 'order_column' => 2],
            ['name' => 'Damage Control Specialist', 'department_id' => 5, 'status' => PositionStatus::active, 'order_column' => 3],

            ['name' => 'Chief Science Officer', 'department_id' => 6, 'status' => PositionStatus::active, 'order_column' => 0],
            ['name' => 'Scientist', 'department_id' => 6, 'status' => PositionStatus::active, 'order_column' => 1],

            ['name' => 'Chief Medical Officer', 'department_id' => 7, 'status' => PositionStatus::active, 'order_column' => 0],
            ['name' => 'Chief Surgeon', 'department_id' => 7, 'status' => PositionStatus::active, 'order_column' => 1],
            ['name' => 'Chief Counselor', 'department_id' => 7, 'status' => PositionStatus::active, 'order_column' => 2],

            ['name' => 'Marine CO', 'department_id' => 8, 'status' => PositionStatus::active, 'order_column' => 0],
            ['name' => 'Marine XO', 'department_id' => 8, 'status' => PositionStatus::active, 'order_column' => 1],
            ['name' => 'Marine', 'department_id' => 8, 'status' => PositionStatus::active, 'order_column' => 2],

            ['name' => 'Bartender', 'department_id' => 9, 'status' => PositionStatus::active, 'order_column' => 0],
            ['name' => 'Barber', 'department_id' => 9, 'status' => PositionStatus::active, 'order_column' => 1],
            ['name' => 'School teacher', 'department_id' => 9, 'status' => PositionStatus::active, 'order_column' => 2],
        ];

        collect($positions)->each([Position::class, 'create']);

        activity()->enableLogging();
    }
}
