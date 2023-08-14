<?php

declare(strict_types=1);
use Nova\Departments\Actions\DuplicatePosition;
use Nova\Departments\Data\PositionData;
use Nova\Departments\Models\Position;
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->position = Position::factory()->create([
        'name' => 'Commanding Officer',
        'description' => 'My original description',
    ]);
});
it('duplicates a position', function () {
    $position = DuplicatePosition::run($this->position, PositionData::from([
        'name' => 'Executive Officer',
        'description' => $this->position->description,
        'status' => $this->position->status,
        'available' => $this->position->available,
        'department_id' => $this->position->department_id,
    ]));

    expect($position->exists)->toBeTrue();
    expect($position->name)->toEqual('Executive Officer');
    expect($position->description)->toEqual('My original description');
    expect($position->department_id)->toEqual($this->position->department_id);
    expect($position->available)->toEqual($this->position->available);
});
