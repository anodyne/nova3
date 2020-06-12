<?php

use Nova\Roles\Models\Role;
use Nova\Roles\Events\RoleCreated;
use Illuminate\Support\Facades\Event;
use Nova\Roles\Http\Requests\CreateRoleRequest;

uses()->group('feature', 'roles');

test('an authorized user can view the create role page', function () {
    $this->signInWithPermission('role.create');

    $response = $this->get(route('roles.create'));
    $response->assertSuccessful();
});

test('an authorized user can create a role', function () {
    $this->signInWithPermission('role.create');

    $roleData = factory(Role::class)->make();

    $postData = array_merge($roleData->toArray(), [
        'permissions' => ['foo', 'bar', 'baz'],
        'users' => [],
    ]);

    $this->followingRedirects();

    $response = $this->post(route('roles.store'), $postData);

    $response->assertSuccessful();

    $role = Role::get()->last();

    $this->assertCount(3, $role->permissions);

    $this->assertDatabaseHas('roles', [
        'name' => $roleData->name,
        'display_name' => $roleData->display_name,
    ]);
});

test('an unauthorized user cannot view the create role page', function () {
    $this->signIn();

    $response = $this->get(route('roles.create'));
    $response->assertForbidden();
});

test('an unauthorized user cannot create a role', function () {
    $this->signIn();

    $response = $this->postJson(
        route('roles.store'),
        factory(Role::class)->make()->toArray()
    );
    $response->assertForbidden();
});

test('an unauthenticated user cannot view the create role page')
    ->get('/roles/create')
    ->assertRedirect('/login');

test('an unauthenticated user cannot create a role')
    ->postJson('/roles')
    ->assertUnauthorized();

test('an event is dispatched when a role is created', function () {
    Event::fake();

    $this->signInWithPermission('role.create');

    $data = array_merge(factory(Role::class)->make()->toArray(), [
        'permissions' => ['foo', 'bar', 'baz'],
        'users' => [],
    ]);

    $this->post(route('roles.store'), $data);

    $role = Role::get()->last();

    Event::assertDispatched(RoleCreated::class, function ($event) use ($role) {
        return $event->role->is($role);
    });
});

test('a role can be given to a user', function () {
    $this->signInWithPermission('role.create');

    $user = $this->createUser();

    $role = factory(Role::class)->make();

    $this->post(route('roles.store'), array_merge($role->toArray(), [
        'permissions' => [],
        'users' => [$user->id],
    ]));

    $this->assertTrue($user->hasRole($role->name));
});

test('activity is logged when a role is created', function () {
    $role = factory(Role::class)->create();

    $this->assertDatabaseHas('activity_log', [
        'description' => $role->display_name . ' role was created',
    ]);
});

test('creating a role uses the correct form request')
    ->assertRouteUsesFormRequest('roles.store', CreateRoleRequest::class);
