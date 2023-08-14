<?php

declare(strict_types=1);
use Illuminate\Support\Facades\Event;
use Nova\Roles\Events\RoleUpdated;
use Nova\Roles\Models\Permission;
use Nova\Roles\Models\Role;
use Nova\Roles\Requests\UpdateRoleRequest;
use Nova\Users\Models\User;
beforeEach(function () {
    $this->disableRoleCaching();

    $this->role = Role::factory()->create();
});
test('authorized user can view the edit role page', function () {
    $this->signInWithPermission('role.update');

    $response = $this->get(route('roles.edit', $this->role));
    $response->assertSuccessful();
});
test('authorized user can update role', function () {
    $this->signInWithPermission('role.update');

    $role = Role::factory()->make();

    $this->followingRedirects();

    $response = $this->put(
        route('roles.update', $this->role),
        array_merge($role->toArray(), [
            'id' => $this->role->id,
        ])
    );
    $response->assertSuccessful();

    $this->assertDatabaseHas('roles', $role->only('name', 'display_name'));

    $this->assertRouteUsesFormRequest(
        'roles.update',
        UpdateRoleRequest::class
    );
});
test('permissions can be added to a role', function () {
    $this->markTestSkipped('Need to test Livewire component');

    $this->signInWithPermission('role.update');

    $permission1 = Permission::find(1);
    $permission2 = Permission::find(2);

    $this->role->givePermission($permission1);

    $role = Role::factory()->make();

    $this->followingRedirects();

    $response = $this->put(
        route('roles.update', $this->role),
        array_merge($role->toArray(), [
            'id' => $this->role->id,
            'permissions' => [$permission1->id, $permission2->id],
            'users' => [],
        ])
    );
    $response->assertSuccessful();

    expect($this->role->refresh()->hasPermission($permission1->name))->toBeTrue();
    expect($this->role->hasPermission($permission2->name))->toBeTrue();

    $this->assertDatabaseHas('permission_role', [
        'role_id' => $this->role->id,
        'permission_id' => $permission1->id,
    ]);

    $this->assertDatabaseHas('permission_role', [
        'role_id' => $this->role->id,
        'permission_id' => $permission2->id,
    ]);
});
test('permissions can be removed from a role', function () {
    $this->markTestSkipped('Need to test Livewire component');

    $this->signInWithPermission('role.update');

    $permission1 = Permission::find(1);
    $permission2 = Permission::find(2);

    $this->role->givePermissions([$permission1, $permission2]);

    $role = Role::factory()->make();

    $this->followingRedirects();

    $response = $this->put(
        route('roles.update', $this->role),
        array_merge($role->toArray(), [
            'id' => $this->role->id,
            'permissions' => [$permission1->id],
            'users' => [],
        ])
    );
    $response->assertSuccessful();

    expect($this->role->refresh()->hasPermission($permission1->name))->toBeTrue();
    expect($this->role->hasPermission($permission2->name))->toBeFalse();

    $this->assertDatabaseHas('permission_role', [
        'role_id' => $this->role->id,
        'permission_id' => $permission1->id,
    ]);

    $this->assertDatabaseMissing('permission_role', [
        'role_id' => $this->role->id,
        'permission_id' => $permission2->id,
    ]);
});
test('users can be added to a role', function () {
    $this->markTestSkipped('Need to test Livewire component');

    $this->signInWithPermission('role.update');

    $john = User::factory()->active()->create();
    $jane = User::factory()->active()->create();

    $john->addRole($this->role);

    $role = Role::factory()->make();

    $this->followingRedirects();

    $response = $this->put(
        route('roles.update', $this->role),
        array_merge($role->toArray(), [
            'id' => $this->role->id,
            'users' => [$john->id, $jane->id],
        ])
    );
    $response->assertSuccessful();

    expect($this->role->refresh()->user->contains('id', $john->id))->toBeTrue();
    expect($this->role->user->contains('id', $jane->id))->toBeTrue();

    $this->assertDatabaseHas('role_user', [
        'role_id' => $this->role->id,
        'user_id' => $john->id,
    ]);

    $this->assertDatabaseHas('role_user', [
        'role_id' => $this->role->id,
        'user_id' => $jane->id,
    ]);
});
test('users can be removed from a role', function () {
    $this->markTestSkipped('Need to test Livewire component');

    $this->signInWithPermission('role.update');

    $john = User::factory()->active()->create();
    $jane = User::factory()->active()->create();

    $john->addRole($this->role);
    $jane->addRole($this->role);

    $role = Role::factory()->make();

    $this->followingRedirects();

    $response = $this->put(
        route('roles.update', $this->role),
        array_merge($role->toArray(), [
            'id' => $this->role->id,
            'users' => [$jane->id],
        ])
    );
    $response->assertSuccessful();

    expect($this->role->refresh()->user->contains('id', $john->id))->toBeFalse();
    expect($this->role->user->contains('id', $jane->id))->toBeTrue();

    $this->assertDatabaseMissing('role_user', [
        'role_id' => $this->role->id,
        'user_id' => $john->id,
    ]);

    $this->assertDatabaseHas('role_user', [
        'role_id' => $this->role->id,
        'user_id' => $jane->id,
    ]);
});
test('event is dispatched when role is updated', function () {
    Event::fake();

    $this->signInWithPermission('role.update');

    $this->put(
        route('roles.update', $this->role),
        Role::factory()->make()->toArray()
    );

    Event::assertDispatched(RoleUpdated::class);
});
test('unauthorized user cannot view the edit role page', function () {
    $this->signIn();

    $response = $this->get(route('roles.edit', $this->role));
    $response->assertForbidden();
});
test('unauthorized user cannot update role', function () {
    $this->signIn();

    $response = $this->putJson(
        route('roles.update', $this->role),
        Role::factory()->make()->toArray()
    );
    $response->assertForbidden();
});
test('unauthenticated user cannot view the edit role page', function () {
    $response = $this->getJson(route('roles.edit', $this->role));
    $response->assertUnauthorized();
});
test('unauthenticated user cannot update role', function () {
    $response = $this->putJson(
        route('roles.update', $this->role),
        Role::factory()->make()->toArray()
    );
    $response->assertUnauthorized();
});
test('locked role key cannot be updated', function () {
    $role = Role::factory()->locked()->create();

    $this->signInWithPermission('role.update');

    $response = $this->put(route('roles.update', $role), [
        'display_name' => 'Foo',
        'name' => 'foo',
    ]);

    $this->assertDatabaseHas('roles', [
        'display_name' => 'Foo',
        'name' => $role->name,
        'locked' => true,
    ]);
});
test('role can be revoked from user', function () {
    $this->markTestSkipped('Need to test Livewire component');

    $this->signInWithPermission('role.update');

    $user = User::factory()->active()->create();
    $user->addRole($this->role);

    expect($user->hasRole($this->role->name))->toBeTrue();

    $response = $this->put(route('roles.update', $this->role), [
        'id' => $this->role->id,
        'name' => $this->role->name,
        'display_name' => $this->role->display_name,
        'users' => [],
        'default' => false,
    ]);

    $this->followRedirects($response)->assertSuccessful();

    expect($user->refresh()->hasRole($this->role->name))->toBeFalse();
});
test('role can be given to user', function () {
    $this->markTestSkipped('Need to test Livewire component');

    $this->signInWithPermission('role.update');

    $user = User::factory()->active()->create();

    expect($user->hasRole($this->role->name))->toBeFalse();

    $response = $this->put(route('roles.update', $this->role), [
        'id' => $this->role->id,
        'name' => $this->role->name,
        'display_name' => $this->role->display_name,
        'users' => [$user->id],
        'default' => false,
    ]);

    $this->followRedirects($response)->assertSuccessful();

    expect($user->refresh()->hasRole($this->role->name))->toBeTrue();
});
