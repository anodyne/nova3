<?php

use Illuminate\Support\Facades\Event;
use Nova\Departments\Events\DepartmentDuplicated;
use Nova\Departments\Models\Department;

beforeEach(function () {
    $this->department = Department::factory()
        ->hasPositions(1, function (array $attributes, Department $department) {
            return ['department_id' => $department->id];
        })->create([
            'name' => 'Command',
        ]);
});

test('authorized user can duplicate department', function () {
    $this->signInWithPermission(['department.create', 'department.update']);

    $this->followingRedirects();

    $response = $this->post(
        route('departments.duplicate', $this->department),
        ['name' => 'New Name']
    );
    $response->assertSuccessful();

    $newDepartment = Department::get()->last();

    $this->assertDatabaseHas('departments', [
        'name' => 'New Name',
    ]);

    $this->assertDatabaseHas('positions', [
        'department_id' => $newDepartment->id,
    ]);
});

test('event is dispatched when department is duplicated', function () {
    Event::fake();

    $this->signInWithPermission(['department.create', 'department.update']);

    $this->post(
        route('departments.duplicate', $this->department),
        ['name' => 'New Name']
    );

    Event::assertDispatched(DepartmentDuplicated::class);
});

test('unauthorized user cannot duplicate department', function () {
    $this->signIn();

    $response = $this->post(route('departments.duplicate', $this->department));
    $response->assertNotFound();
});

test('unauthenticated user cannot duplicate department', function () {
    $response = $this->postJson(
        route('departments.duplicate', $this->department)
    );
    $response->assertUnauthorized();
});
