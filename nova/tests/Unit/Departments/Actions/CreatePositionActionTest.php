<?php

declare(strict_types=1);
use Nova\Departments\Actions\CreatePosition;
use Nova\Departments\Data\PositionData;
use Nova\Departments\Enums\PositionStatus;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->department = Department::factory()->create();
});
it('creates a position', function () {
    $data = PositionData::from([
        'name' => 'Captain',
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
        'available' => 1,
        'department' => $this->department,
        'department_id' => $this->department->id,
        'status' => PositionStatus::active,
    ]);

    $position = CreatePosition::run($data);

    expect($position->exists)->toBeTrue();
    expect($position->name)->toEqual('Captain');
    expect($position->description)->toEqual('Lorem ipsum dolor sit amet, consectetur adipisicing elit.');
    expect($position->available)->toEqual(1);
    expect($position->department_id)->toEqual($this->department->id);
});
it('sets the correct sort order for a newly created position', function () {
    Position::factory()->create([
        'department_id' => $this->department,
        'sort' => 0,
    ]);
    Position::factory()->create([
        'department_id' => $this->department,
        'sort' => 1,
    ]);

    $data = PositionData::from([
        'name' => 'Captain',
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
        'available' => 1,
        'department' => $this->department,
        'department_id' => $this->department->id,
        'status' => PositionStatus::active,
    ]);

    $position = CreatePosition::run($data);

    expect($position->sort)->toEqual(2);
});
