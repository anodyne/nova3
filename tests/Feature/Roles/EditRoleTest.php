<?php

declare(strict_types=1);

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use Nova\Roles\Events\RoleUpdated;
use Nova\Roles\Livewire\ManagePermissions;
use Nova\Roles\Livewire\ManageUsers;
use Nova\Roles\Models\Permission;
use Nova\Roles\Models\Role;
use Nova\Users\Models\User;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\put;
use function Pest\Livewire\livewire;

uses()->group('roles');

beforeEach(function () {
    $this->role = Role::factory()->create();
});

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'role.update');
    });

    test('can view the edit role page', function () {
        get(route('roles.edit', $this->role))->assertSuccessful();
    });

    test('can update a role', function () {
        Event::fake();

        $data = Role::factory()->make();

        from(route('roles.edit', $this->role))
            ->followingRedirects()
            ->put(route('roles.update', $this->role), $data->toArray())
            ->assertSuccessful();

        assertDatabaseHas(Role::class, $data->toArray());

        Event::assertDispatched(RoleUpdated::class);
    });

    test('can assign users to a role when creating it', function () {
        $user = User::factory()->create();

        $assignedUsers = livewire(ManageUsers::class, ['role' => $this->role])
            ->call('assignUser', $user->id)
            ->get('assignedUsers');

        $data = array_merge(
            Role::factory()->make()->toArray(),
            ['assigned_users' => $assignedUsers]
        );

        from(route('roles.edit', $this->role))
            ->followingRedirects()
            ->put(route('roles.update', $this->role), $data)
            ->assertSuccessful();

        assertDatabaseHas(Role::class, Arr::only($data, ['name', 'display_name']));

        assertDatabaseHas('role_user', [
            'role_id' => $this->role->id,
            'user_id' => $user->id,
        ]);
    });

    test('can add permissions to a role when creating it', function () {
        $permission = Permission::first();

        $assignedPermissions = livewire(ManagePermissions::class, ['role' => $this->role])
            ->call('addPermission', $permission->id)
            ->get('assignedPermissions');

        $data = array_merge(
            Role::factory()->make()->toArray(),
            ['assigned_permissions' => $assignedPermissions]
        );

        from(route('roles.edit', $this->role))
            ->followingRedirects()
            ->put(route('roles.update', $this->role), $data)
            ->assertSuccessful();

        assertDatabaseHas(Role::class, Arr::only($data, ['name', 'display_name']));

        assertDatabaseHas('permission_role', [
            'role_id' => $this->role->id,
            'permission_id' => $permission->id,
        ]);
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the edit role page', function () {
        get(route('roles.edit', $this->role))->assertForbidden();
    });

    test('cannot update a role', function () {
        put(route('roles.update', $this->role), [])->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the edit role page', function () {
        get(route('roles.edit', $this->role))
            ->assertRedirect(route('login'));
    });

    test('cannot update a role', function () {
        put(route('roles.update', $this->role), [])
            ->assertRedirect(route('login'));
    });
});
