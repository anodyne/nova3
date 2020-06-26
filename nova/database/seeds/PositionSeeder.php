<?php

use Illuminate\Database\Seeder;
use Nova\Departments\Models\Position;
use Nova\Departments\Models\Department;

class PositionSeeder extends Seeder
{
    public function run()
    {
        activity()->disableLogging();

        $departments = Department::get();

        $departments->each(function ($department) {
            factory(Position::class)->times(mt_rand(3, 10))->create([
                'department_id' => $department,
            ]);
        });

        activity()->enableLogging();
    }
}
