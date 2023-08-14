<?php

declare(strict_types=1);
use Illuminate\Support\Facades\Event;
use Nova\Roles\Events\RoleDeleted;
use Nova\Roles\Models\Role;
use Nova\Users\Models\User;
beforeEach(function () {
    $this->disableRoleCaching();

    $this->role = Role::factory()->create();
});
test('authorized user can delete role', function () {
    $this->signInWithPermission('role.delete');

    $this->followingRedirects();

    $response = $this->delete(route('roles.destroy', $this->role));
    $response->assertSuccessful();

    $this->assertDatabaseMissing('roles', [
        'id' => $this->role->id,
    ]);
});
test('users with role that has been deleted have that role removed from their roles', function () {
    $this->signInWithPermission('role.delete');

    $user = User::factory()->active()->create();
    $user->addRole($this->role->name);

    $this->delete(route('roles.destroy', $this->role));

    expect($user->refresh()->roles)->toHaveCount(0);
    expect($user->hasRole($this->role->name))->toBeFalse();
});
test('event is dispatched when role is deleted', function () {
    Event::fake();

    $this->signInWithPermission('role.delete');

    $this->delete(route('roles.destroy', $this->role));

    Event::assertDispatched(RoleDeleted::class);
});
test('locked role cannot be deleted', function () {
    $this->signInWithPermission('role.delete');

    $role = Role::factory()->locked()->create();

    $response = $this->delete(route('roles.destroy', $role));
    $response->assertForbidden();

    $this->assertDatabaseHas('roles', [
        'id' => $role->id,
        'locked' => true,
    ]);
});
test('unauthorized user cannot delete role', function () {
    $this->signIn();

    $response = $this->delete(route('roles.destroy', $this->role));
    $response->assertForbidden();
});
test('unauthenticated user cannot delete role', function () {
    $response = $this->deleteJson(route('roles.destroy', $this->role));
    $response->assertUnauthorized();
});
