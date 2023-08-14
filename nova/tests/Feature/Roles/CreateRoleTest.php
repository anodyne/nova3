<?php

declare(strict_types=1);
use Illuminate\Support\Facades\Event;
use Nova\Roles\Events\RoleCreated;
use Nova\Roles\Models\Role;
use Nova\Roles\Requests\CreateRoleRequest;
beforeEach(function () {
    $this->disableRoleCaching();
});
test('authorized user can view the create role page', function () {
    $this->signInWithPermission('role.create');

    $response = $this->get(route('roles.create'));
    $response->assertSuccessful();
});
test('authorized user can create role', function () {
    $this->signInWithPermission('role.create');

    $role = Role::factory()->make();

    $this->followingRedirects();

    $response = $this->post(route('roles.store'), $role->toArray());
    $response->assertSuccessful();

    $this->assertDatabaseHas('roles', $role->only('name', 'display_name'));

    $this->assertRouteUsesFormRequest(
        'roles.store',
        CreateRoleRequest::class
    );
});
test('role can be created as a default role for new users', function () {
    $this->signInWithPermission('role.create');

    $role = Role::factory()->default()->make();

    $this->followingRedirects();

    $response = $this->post(route('roles.store'), $role->toArray());
    $response->assertSuccessful();

    expect(Role::default()->get()->contains('name', $role->name))->toBeTrue();

    $this->assertDatabaseHas(
        'roles',
        $role->only('name', 'display_name', 'default')
    );
});
test('event is dispatched when role is created', function () {
    Event::fake();

    $this->signInWithPermission('role.create');

    $this->post(route('roles.store'), Role::factory()->make()->toArray());

    Event::assertDispatched(RoleCreated::class);
});
test('unauthorized user cannot view the create role page', function () {
    $this->signIn();

    $response = $this->get(route('roles.create'));
    $response->assertForbidden();
});
test('unauthorized user cannot create role', function () {
    $this->signIn();

    $response = $this->postJson(
        route('roles.store'),
        Role::factory()->make()->toArray()
    );
    $response->assertForbidden();
});
test('unauthenticated user cannot view the create role page', function () {
    $response = $this->getJson(route('roles.create'));
    $response->assertUnauthorized();
});
test('unauthenticated user cannot create role', function () {
    $response = $this->postJson(
        route('roles.store'),
        Role::factory()->make()->toArray()
    );
    $response->assertUnauthorized();
});
