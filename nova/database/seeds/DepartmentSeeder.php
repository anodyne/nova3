<?php

use Illuminate\Database\Seeder;
use Nova\Departments\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        $departments = [
            ['name' => 'Command', 'description' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Adipisci, totam numquam voluptatem cum repellat quos commodi sed repudiandae ut ducimus illo culpa voluptate saepe ipsam nostrum unde ab. Facilis, ipsum?', 'sort' => 0],
            ['name' => 'Flight Control', 'description' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Adipisci, totam numquam voluptatem cum repellat quos commodi sed repudiandae ut ducimus illo culpa voluptate saepe ipsam nostrum unde ab. Facilis, ipsum?', 'sort' => 1],
            ['name' => 'Operations', 'description' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Adipisci, totam numquam voluptatem cum repellat quos commodi sed repudiandae ut ducimus illo culpa voluptate saepe ipsam nostrum unde ab. Facilis, ipsum?', 'sort' => 2],
            ['name' => 'Security/Tactical', 'description' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Adipisci, totam numquam voluptatem cum repellat quos commodi sed repudiandae ut ducimus illo culpa voluptate saepe ipsam nostrum unde ab. Facilis, ipsum?', 'sort' => 3],
            ['name' => 'Engineering', 'description' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Adipisci, totam numquam voluptatem cum repellat quos commodi sed repudiandae ut ducimus illo culpa voluptate saepe ipsam nostrum unde ab. Facilis, ipsum?', 'sort' => 4],
            ['name' => 'Science', 'description' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Adipisci, totam numquam voluptatem cum repellat quos commodi sed repudiandae ut ducimus illo culpa voluptate saepe ipsam nostrum unde ab. Facilis, ipsum?', 'sort' => 5],
            ['name' => 'Medical', 'description' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Adipisci, totam numquam voluptatem cum repellat quos commodi sed repudiandae ut ducimus illo culpa voluptate saepe ipsam nostrum unde ab. Facilis, ipsum?', 'sort' => 6],
            ['name' => 'Marines', 'description' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Adipisci, totam numquam voluptatem cum repellat quos commodi sed repudiandae ut ducimus illo culpa voluptate saepe ipsam nostrum unde ab. Facilis, ipsum?', 'sort' => 7],
        ];

        activity()->disableLogging();

        collect($departments)->each([Department::class, 'create']);

        activity()->enableLogging();
    }
}
