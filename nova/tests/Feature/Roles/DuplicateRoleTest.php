<?php

declare(strict_types=1);
use Illuminate\Support\Facades\Event;
use Nova\Roles\Events\RoleDuplicated;
use Nova\Roles\Models\Permission;
use Nova\Roles\Models\Role;
beforeEach(function () {
    $this->disableRoleCaching();

    $this->role = Role::factory()->create([
        'name' => 'foo',
        'display_name' => 'Foo',
    ]);
});
test('authorized user can duplicate role', function () {
    $this->signInWithPermission(['role.create', 'role.update']);

    $this->role->givePermission($permission = Permission::first());

    $this->followingRedirects();

    $response = $this->post(route('roles.duplicate', $this->role));
    $response->assertSuccessful();

    $role = Role::get()->last();

    expect($this->role->refresh()->permissions)->toHaveCount(1);
    expect($role->permissions)->toHaveCount(1);
    expect($role->hasPermission($permission->name))->toBeTrue();

    $this->assertDatabaseHas('roles', [
        'display_name' => "Copy of {$this->role->display_name}",
    ]);
});
test('event is dispatched when role is duplicated', function () {
    Event::fake();

    $this->signInWithPermission(['role.create', 'role.update']);

    $this->post(route('roles.duplicate', $this->role));

    Event::assertDispatched(RoleDuplicated::class);
});
test('locked role cannot be duplicated', function () {
    $role = Role::factory()->locked()->create();

    $this->signInWithPermission(['role.create', 'role.update']);

    $roleCount = Role::count();

    $response = $this->postJson(route('roles.duplicate', $role));
    $response->assertForbidden();

    expect(Role::count())->toEqual($roleCount);
});
test('unauthorized user cannot duplicate role', function () {
    $this->signIn();

    $response = $this->post(route('roles.duplicate', $this->role));
    $response->assertForbidden();
});
test('unauthenticated user cannot duplicate role', function () {
    $response = $this->postJson(route('roles.duplicate', $this->role));
    $response->assertUnauthorized();
});
