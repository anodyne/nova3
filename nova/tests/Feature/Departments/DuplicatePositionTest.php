<?php

declare(strict_types=1);
use Illuminate\Support\Facades\Event;
use Nova\Departments\Events\PositionDuplicated;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;
beforeEach(function () {
    $this->position = Position::factory()
        ->forDepartment([
            'name' => 'Command',
        ])
        ->create([
            'name' => 'Commanding Officer',
        ]);
});
test('authorized user can duplicate a position in the same department', function () {
    $this->signInWithPermission(['department.create', 'department.update']);

    $this->followingRedirects();

    $response = $this->post(
        route('positions.duplicate', $this->position),
        [
            'name' => 'Executive Officer',
            'department_id' => $this->position->department_id,
        ]
    );
    $response->assertSuccessful();

    $this->assertDatabaseHas('positions', [
        'name' => 'Executive Officer',
        'department_id' => $this->position->department_id,
    ]);
});
test('authorized user can duplicate a position in a new department', function () {
    $this->signInWithPermission(['department.create', 'department.update']);

    $this->followingRedirects();

    $department = Department::factory()->create();

    $response = $this->post(
        route('positions.duplicate', $this->position),
        [
            'name' => 'Executive Officer',
            'department_id' => $department->id,
        ]
    );
    $response->assertSuccessful();

    $this->assertDatabaseHas('positions', [
        'name' => 'Executive Officer',
        'department_id' => $department->id,
    ]);
});
test('event is dispatched when position is duplicated', function () {
    Event::fake();

    $this->signInWithPermission(['department.create', 'department.update']);

    $this->post(
        route('positions.duplicate', $this->position),
        [
            'name' => 'Executive Officer',
            'department_id' => $this->position->department_id,
        ]
    );

    Event::assertDispatched(PositionDuplicated::class);
});
test('unauthorized user cannot duplicate position', function () {
    $this->signIn();

    $response = $this->post(route('positions.duplicate', $this->position));
    $response->assertForbidden();
});
test('unauthenticated user cannot duplicate position', function () {
    $response = $this->postJson(
        route('positions.duplicate', $this->position)
    );
    $response->assertUnauthorized();
});
