<?php

declare(strict_types=1);
use Nova\Departments\Actions\UpdateDepartment;
use Nova\Departments\Data\DepartmentData;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\States\Departments\Inactive;
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->department = Department::factory()->create();
});
it('updates a department', function () {
    $data = DepartmentData::from([
        'name' => 'Operations',
        'description' => 'Lorem consectetur adipisicing elit.',
        'status' => Inactive::class,
    ]);

    $department = UpdateDepartment::run($this->department, $data);

    expect($department->exists)->toBeTrue();
    expect($department->name)->toEqual('Operations');
    expect($department->description)->toEqual('Lorem consectetur adipisicing elit.');
    expect($department->status->equals(Inactive::class))->toBeTrue();
});
