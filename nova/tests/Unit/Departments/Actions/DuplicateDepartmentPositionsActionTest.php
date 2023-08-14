<?php

declare(strict_types=1);
use Nova\Departments\Actions\DuplicateDepartment;
use Nova\Departments\Actions\DuplicateDepartmentPositions;
use Nova\Departments\Data\DepartmentData;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\States\Departments\Active;
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->department = Department::factory()
        ->hasPositions(2, function (array $attributes, Department $department) {
            return ['department_id' => $department->id];
        })
        ->create([
            'name' => 'Command',
        ]);
});
it('duplicates the positions from another department', function () {
    $department = DuplicateDepartment::run(
        $this->department,
        DepartmentData::from([
            'name' => 'New Name',
            'status' => Active::class,
        ])
    );

    DuplicateDepartmentPositions::run($department, $this->department);

    $department->refresh();

    expect($department->positions)->toHaveCount(2);
    expect($this->department->positions)->toHaveCount(2);
});
