<?php

declare(strict_types=1);
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use Nova\Departments\Events\DepartmentCreated;
use Nova\Departments\Models\Department;
use Nova\Departments\Requests\CreateDepartmentRequest;
test('authorized user can view the create department page', function () {
    $this->signInWithPermission('department.create');

    $response = $this->get(route('departments.create'));
    $response->assertSuccessful();
});
test('authorized user can create department', function () {
    $this->signInWithPermission('department.create');

    $department = [
        'name' => 'Command',
        'description' => 'Lorem ipsum dolor sit amet',
        'status' => 'active',
    ];

    $this->followingRedirects();

    $response = $this->post(
        route('departments.store'),
        $department
    );
    $response->assertSuccessful();

    $this->assertDatabaseHas(
        'departments',
        Arr::only($department, ['name', 'description'])
    );

    $this->assertRouteUsesFormRequest(
        'departments.store',
        CreateDepartmentRequest::class
    );
});
test('event is dispatched when department is created', function () {
    Event::fake();

    $this->signInWithPermission('department.create');

    $this->post(
        route('departments.store'),
        [
            'name' => 'Command',
            'description' => 'Lorem ipsum dolor sit amet',
            'status' => 'active',
        ]
    );

    Event::assertDispatched(DepartmentCreated::class);
});
test('unauthorized user cannot view the create department page', function () {
    $this->signIn();

    $response = $this->get(route('departments.create'));
    $response->assertNotFound();
});
test('unauthorized user cannot create department', function () {
    $this->signIn();

    $response = $this->postJson(
        route('departments.store'),
        Department::factory()->make()->toArray()
    );
    $response->assertNotFound();
});
test('unauthenticated user cannot view the create department page', function () {
    $response = $this->getJson(route('departments.create'));
    $response->assertUnauthorized();
});
test('unauthenticated user cannot create department', function () {
    $response = $this->postJson(
        route('departments.store'),
        Department::factory()->make()->toArray()
    );
    $response->assertUnauthorized();
});
