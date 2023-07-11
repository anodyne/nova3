<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Nova\Departments\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        $departments = [
            ['name' => 'Command', 'description' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Adipisci, totam numquam voluptatem cum repellat quos commodi sed repudiandae ut ducimus illo culpa voluptate saepe ipsam nostrum unde ab. Facilis, ipsum?', 'order_column' => 0],

            ['name' => 'Flight Control', 'description' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Adipisci, totam numquam voluptatem cum repellat quos commodi sed repudiandae ut ducimus illo culpa voluptate saepe ipsam nostrum unde ab. Facilis, ipsum?', 'order_column' => 1],

            ['name' => 'Operations', 'description' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Adipisci, totam numquam voluptatem cum repellat quos commodi sed repudiandae ut ducimus illo culpa voluptate saepe ipsam nostrum unde ab. Facilis, ipsum?', 'order_column' => 2],

            ['name' => 'Security/Tactical', 'description' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Adipisci, totam numquam voluptatem cum repellat quos commodi sed repudiandae ut ducimus illo culpa voluptate saepe ipsam nostrum unde ab. Facilis, ipsum?', 'order_column' => 3],

            ['name' => 'Engineering', 'description' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Adipisci, totam numquam voluptatem cum repellat quos commodi sed repudiandae ut ducimus illo culpa voluptate saepe ipsam nostrum unde ab. Facilis, ipsum?', 'order_column' => 4],

            ['name' => 'Science', 'description' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Adipisci, totam numquam voluptatem cum repellat quos commodi sed repudiandae ut ducimus illo culpa voluptate saepe ipsam nostrum unde ab. Facilis, ipsum?', 'order_column' => 5],

            ['name' => 'Medical', 'description' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Adipisci, totam numquam voluptatem cum repellat quos commodi sed repudiandae ut ducimus illo culpa voluptate saepe ipsam nostrum unde ab. Facilis, ipsum?', 'order_column' => 6],

            ['name' => 'Marines', 'description' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Adipisci, totam numquam voluptatem cum repellat quos commodi sed repudiandae ut ducimus illo culpa voluptate saepe ipsam nostrum unde ab. Facilis, ipsum?', 'order_column' => 7],

            ['name' => 'Civilians', 'description' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Adipisci, totam numquam voluptatem cum repellat quos commodi sed repudiandae ut ducimus illo culpa voluptate saepe ipsam nostrum unde ab. Facilis, ipsum?', 'order_column' => 8],
        ];

        activity()->disableLogging();

        collect($departments)->each([Department::class, 'create']);

        activity()->enableLogging();
    }
}
