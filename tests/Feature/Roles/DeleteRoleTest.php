<?php

use Nova\Roles\Models\Role;
use Nova\Roles\Events\RoleDeleted;
use Illuminate\Support\Facades\Event;

uses()->group('feature', 'roles');

beforeEach(function () {
    $this->role = factory(Role::class)->create();
});

test('an authorized user can delete a role', function () {
    $this->signInWithPermission('role.delete');

    $response = $this->delete(route('roles.destroy', $this->role));

    $this->followRedirects($response)->assertSuccessful();

    $this->assertDatabaseMissing('roles', $this->role->only('id'));
});

test('an unauthorized user cannot delete a role', function () {
    $this->signIn();

    $response = $this->delete(route('roles.destroy', $this->role));

    $response->assertForbidden();
});

test('an unauthenticated user cannot delete a role', function () {
    $response = $this->deleteJson(route('roles.destroy', $this->role));
    $response->assertUnauthorized();
});

test('a locked role cannot be deleted', function () {
    $role = factory(Role::class)->states('locked')->create();

    $this->signInWithPermission('role.delete');

    $response = $this->delete(route('roles.destroy', $role));
    $response->assertForbidden();

    $this->assertDatabaseHas('roles', $role->only('id', 'locked'));
});

test('an event is dispatched when a role is deleted', function () {
    Event::fake();

    $this->signInWithPermission('role.delete');

    $this->delete(route('roles.destroy', $this->role));

    Event::assertDispatched(RoleDeleted::class, function ($event) {
        return $event->role->is($this->role);
    });
});

test('when a role is deleted any users with that role have it removed', function () {
    $user = $this->createUser();
    $user->attachRole($this->role->name);

    $this->signInWithPermission('role.delete');

    $this->delete(route('roles.destroy', $this->role));

    $this->assertCount(0, $user->roles);
});

test('activity is logged when a role is deleted', function () {
    $this->role->delete();

    $this->assertDatabaseHas('activity_log', [
        'description' => $this->role->display_name . ' role was deleted',
    ]);
});
