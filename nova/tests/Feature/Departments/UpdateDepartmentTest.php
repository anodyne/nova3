<?php

declare(strict_types=1);
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use Nova\Departments\Events\DepartmentUpdated;
use Nova\Departments\Models\Department;
use Nova\Departments\Requests\UpdateDepartmentRequest;
beforeEach(function () {
    $this->department = Department::factory()->create();
});
test('authorized user can view the edit department page', function () {
    $this->signInWithPermission('department.update');

    $response = $this->get(route('departments.edit', $this->department));
    $response->assertSuccessful();
});
test('authorized user can update department', function () {
    $this->signInWithPermission('department.update');

    $department = [
        'name' => 'Command',
        'description' => 'Lorem ipsum dolor sit amet',
        'status' => 'active',
    ];

    $this->followingRedirects();

    $response = $this->put(
        route('departments.update', $this->department),
        $department
    );
    $response->assertSuccessful();

    $this->assertDatabaseHas('departments', Arr::only($department, 'name'));

    $this->assertRouteUsesFormRequest(
        'departments.update',
        UpdateDepartmentRequest::class
    );
});
test('event is dispatched when department is updated', function () {
    Event::fake();

    $this->signInWithPermission('department.update');

    $this->put(
        route('departments.update', $this->department),
        [
            'name' => 'Command',
            'description' => 'Lorem ipsum dolor sit amet',
            'status' => 'active',
        ]
    );

    Event::assertDispatched(DepartmentUpdated::class);
});
test('unauthorized user cannot view the edit department page', function () {
    $this->signIn();

    $response = $this->get(route('departments.edit', $this->department));
    $response->assertNotFound();
});
test('unauthorized user cannot update department', function () {
    $this->signIn();

    $response = $this->putJson(
        route('departments.update', $this->department),
        Department::factory()->make()->toArray()
    );
    $response->assertNotFound();
});
test('unauthenticated user cannot view the edit department page', function () {
    $response = $this->getJson(route('departments.edit', $this->department));
    $response->assertUnauthorized();
});
test('unauthenticated user cannot update department', function () {
    $response = $this->putJson(
        route('departments.update', $this->department),
        Department::factory()->make()->toArray()
    );
    $response->assertUnauthorized();
});
