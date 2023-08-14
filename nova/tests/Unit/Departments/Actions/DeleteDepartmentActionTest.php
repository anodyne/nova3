<?php

declare(strict_types=1);
use Nova\Departments\Actions\DeleteDepartment;
use Nova\Departments\Models\Department;
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->department = Department::factory()->create();
});
it('deletes a department', function () {
    $department = DeleteDepartment::run($this->department);

    expect($department->exists)->toBeFalse();
});
