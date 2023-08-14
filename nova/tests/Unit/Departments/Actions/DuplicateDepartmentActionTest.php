<?php

declare(strict_types=1);
use Nova\Departments\Actions\DuplicateDepartment;
use Nova\Departments\Data\DepartmentData;
use Nova\Departments\Models\Department;
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->department = Department::factory()->create([
        'name' => 'Command',
        'description' => 'My original description',
    ]);
});
it('duplicates a department', function () {
    $department = DuplicateDepartment::run($this->department, DepartmentData::from([
        'name' => 'New Name',
        'description' => $this->department->description,
        'status' => $this->department->status,
    ]));

    expect($department->exists)->toBeTrue();
    expect($department->name)->toEqual('New Name');
    expect($department->description)->toEqual('My original description');
});
