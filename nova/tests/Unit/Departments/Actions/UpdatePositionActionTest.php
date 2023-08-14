<?php

declare(strict_types=1);
use Nova\Departments\Actions\UpdatePosition;
use Nova\Departments\Data\PositionData;
use Nova\Departments\Enums\PositionStatus;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->position = Position::factory()->create();
});
it('updates a position', function () {
    $newDepartment = Department::factory()->create();

    $data = PositionData::from([
        'name' => 'Executive Officer',
        'description' => 'Lorem consectetur adipisicing elit.',
        'status' => PositionStatus::inactive,
        'available' => 5,
        'department_id' => $newDepartment->id,
        'department' => $newDepartment,
    ]);

    $position = UpdatePosition::run($this->position, $data);

    expect($position->exists)->toBeTrue();
    expect($position->name)->toEqual('Executive Officer');
    expect($position->description)->toEqual('Lorem consectetur adipisicing elit.');
    expect($position->status === PositionStatus::inactive)->toBeTrue();
    expect($position->department_id)->toEqual($newDepartment->id);
    expect($position->available)->toEqual(5);
});
