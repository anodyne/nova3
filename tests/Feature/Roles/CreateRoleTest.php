<?php

declare(strict_types=1);

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use Nova\Roles\Events\RoleCreated;
use Nova\Roles\Livewire\ManagePermissions;
use Nova\Roles\Livewire\ManageUsers;
use Nova\Roles\Models\Permission;
use Nova\Roles\Models\Role;
use Nova\Users\Models\User;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Livewire\livewire;

uses()->group('roles');

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'role.create');
    });

    test('can view the create role page', function () {
        get(route('roles.create'))->assertSuccessful();
    });

    test('can create a role', function () {
        Event::fake();

        $data = Role::factory()->make();

        from(route('roles.create'))
            ->followingRedirects()
            ->post(route('roles.store'), $data->toArray())
            ->assertSuccessful();

        assertDatabaseHas(Role::class, $data->toArray());

        Event::assertDispatched(RoleCreated::class);
    });

    test('can create a role that is a default role for new users', function () {
        $data = Role::factory()->default()->make();

        from(route('roles.create'))
            ->followingRedirects()
            ->post(route('roles.store'), $data->toArray())
            ->assertSuccessful();

        assertDatabaseHas(Role::class, $data->toArray());
    });

    test('can assign users to a role when creating it', function () {
        $user = User::factory()->create();

        $assignedUsers = livewire(ManageUsers::class)
            ->call('assignUser', $user->id)
            ->get('assignedUsers');

        $data = array_merge(
            Role::factory()->make()->toArray(),
            ['assigned_users' => $assignedUsers]
        );

        from(route('roles.create'))
            ->followingRedirects()
            ->post(route('roles.store'), $data)
            ->assertSuccessful();

        assertDatabaseHas(Role::class, Arr::only($data, ['name', 'display_name']));

        assertDatabaseHas('role_user', [
            'role_id' => Role::get()->last()->id,
            'user_id' => $user->id,
        ]);
    });

    test('can add permissions to a role when creating it', function () {
        $permission = Permission::first();

        $assignedPermissions = livewire(ManagePermissions::class)
            ->call('addPermission', $permission->id)
            ->get('assignedPermissions');

        $data = array_merge(
            Role::factory()->make()->toArray(),
            ['assigned_permissions' => $assignedPermissions]
        );

        from(route('roles.create'))
            ->followingRedirects()
            ->post(route('roles.store'), $data)
            ->assertSuccessful();

        assertDatabaseHas(Role::class, Arr::only($data, ['name', 'display_name']));

        assertDatabaseHas('permission_role', [
            'role_id' => Role::get()->last()->id,
            'permission_id' => $permission->id,
        ]);
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the create role page', function () {
        get(route('roles.create'))->assertForbidden();
    });

    test('cannot create a role', function () {
        post(route('roles.store'), [])->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the create role page', function () {
        get(route('roles.create'))
            ->assertRedirect(route('login'));
    });

    test('cannot create a role', function () {
        post(route('roles.store'), [])
            ->assertRedirect(route('login'));
    });
});
