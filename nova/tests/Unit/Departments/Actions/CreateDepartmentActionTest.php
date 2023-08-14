<?php

declare(strict_types=1);
use Nova\Departments\Actions\CreateDepartment;
use Nova\Departments\Data\DepartmentData;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\States\Departments\Active;
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('creates a department', function () {
    $data = DepartmentData::from([
        'name' => 'Command',
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
        'status' => Active::class,
    ]);

    $department = CreateDepartment::run($data);

    expect($department->exists)->toBeTrue();
    expect($department->name)->toEqual('Command');
    expect($department->description)->toEqual('Lorem ipsum dolor sit amet, consectetur adipisicing elit.');
});
it('sets the correct sort order for a newly created department', function () {
    Department::factory()->create(['sort' => 0]);
    Department::factory()->create(['sort' => 1]);

    $data = DepartmentData::from([
        'name' => 'Command',
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
        'status' => Active::class,
    ]);

    $department = CreateDepartment::run($data);

    expect($department->sort)->toEqual(2);
});
