<?php

namespace Tests\Feature\Roles;

use Tests\TestCase;
use Nova\Roles\Models\Role;
use Nova\Users\Models\User;
use Nova\Roles\Models\Permission;
use Nova\Roles\Events\RoleUpdated;
use Illuminate\Support\Facades\Event;
use Nova\Roles\Http\Requests\UpdateRoleRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group roles
 */
class UpdateRoleTest extends TestCase
{
    use RefreshDatabase;

    protected $role;

    public function setUp(): void
    {
        parent::setUp();

        $this->disableRoleCaching();

        $this->role = create(Role::class);
    }

    /** @test **/
    public function authorizedUserCanViewTheEditRolePage()
    {
        $this->signInWithPermission('role.update');

        $response = $this->get(route('roles.edit', $this->role));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserCanUpdateRole()
    {
        $this->signInWithPermission('role.update');

        $role = make(Role::class);

        $this->followingRedirects();

        $response = $this->put(
            route('roles.update', $this->role),
            $role->toArray()
        );
        $response->assertSuccessful();

        $this->assertDatabaseHas('roles', $role->only('name', 'display_name'));

        $this->assertRouteUsesFormRequest(
            'roles.update',
            UpdateRoleRequest::class
        );
    }

    /** @test **/
    public function permissionsCanBeAddedToARole()
    {
        $this->signInWithPermission('role.update');

        $permission1 = Permission::find(1);
        $permission2 = Permission::find(2);

        $this->role->attachPermission($permission1);

        $role = make(Role::class);

        $this->followingRedirects();

        $response = $this->put(
            route('roles.update', $this->role),
            array_merge($role->toArray(), [
                'permissions' => [$permission1->id, $permission2->id],
            ])
        );
        $response->assertSuccessful();

        $this->assertTrue($this->role->refresh()->hasPermission($permission1->name));
        $this->assertTrue($this->role->hasPermission($permission2->name));

        $this->assertDatabaseHas('permission_role', [
            'role_id' => $this->role->id,
            'permission_id' => $permission1->id,
        ]);

        $this->assertDatabaseHas('permission_role', [
            'role_id' => $this->role->id,
            'permission_id' => $permission2->id,
        ]);
    }

    /** @test **/
    public function permissionsCanBeRemovedFromARole()
    {
        $this->signInWithPermission('role.update');

        $permission1 = Permission::find(1);
        $permission2 = Permission::find(2);

        $this->role->attachPermissions([$permission1, $permission2]);

        $role = make(Role::class);

        $this->followingRedirects();

        $response = $this->put(
            route('roles.update', $this->role),
            array_merge($role->toArray(), [
                'permissions' => [$permission1->id],
            ])
        );
        $response->assertSuccessful();

        $this->assertTrue($this->role->refresh()->hasPermission($permission1->name));
        $this->assertFalse($this->role->hasPermission($permission2->name));

        $this->assertDatabaseHas('permission_role', [
            'role_id' => $this->role->id,
            'permission_id' => $permission1->id,
        ]);

        $this->assertDatabaseMissing('permission_role', [
            'role_id' => $this->role->id,
            'permission_id' => $permission2->id,
        ]);
    }

    /** @test **/
    public function usersCanBeAddedToARole()
    {
        $this->signInWithPermission('role.update');

        $john = create(User::class);
        $jane = create(User::class);

        $john->attachRole($this->role);

        $role = make(Role::class);

        $this->followingRedirects();

        $response = $this->put(
            route('roles.update', $this->role),
            array_merge($role->toArray(), [
                'id' => $this->role->id,
                'users' => [$john->id, $jane->id],
            ])
        );
        $response->assertSuccessful();

        $this->assertTrue($this->role->refresh()->users->contains('id', $john->id));
        $this->assertTrue($this->role->users->contains('id', $jane->id));

        $this->assertDatabaseHas('role_user', [
            'role_id' => $this->role->id,
            'user_id' => $john->id,
        ]);

        $this->assertDatabaseHas('role_user', [
            'role_id' => $this->role->id,
            'user_id' => $jane->id,
        ]);
    }

    /** @test **/
    public function usersCanBeRemovedFromARole()
    {
        $this->signInWithPermission('role.update');

        $john = create(User::class);
        $jane = create(User::class);

        $john->attachRole($this->role);
        $jane->attachRole($this->role);

        $role = make(Role::class);

        $this->followingRedirects();

        $response = $this->put(
            route('roles.update', $this->role),
            array_merge($role->toArray(), [
                'id' => $this->role->id,
                'users' => [$jane->id],
            ])
        );
        $response->assertSuccessful();

        $this->assertFalse($this->role->refresh()->users->contains('id', $john->id));
        $this->assertTrue($this->role->users->contains('id', $jane->id));

        $this->assertDatabaseMissing('role_user', [
            'role_id' => $this->role->id,
            'user_id' => $john->id,
        ]);

        $this->assertDatabaseHas('role_user', [
            'role_id' => $this->role->id,
            'user_id' => $jane->id,
        ]);
    }

    /** @test **/
    public function eventIsDispatchedWhenRoleIsUpdated()
    {
        Event::fake();

        $this->signInWithPermission('role.update');

        $this->put(
            route('roles.update', $this->role),
            make(Role::class)->toArray()
        );

        Event::assertDispatched(RoleUpdated::class);
    }

    /** @test **/
    public function unauthorizedUserCannotViewTheEditRolePage()
    {
        $this->signIn();

        $response = $this->get(route('roles.edit', $this->role));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthorizedUserCannotUpdateRole()
    {
        $this->signIn();

        $response = $this->putJson(
            route('roles.update', $this->role),
            make(Role::class)->toArray()
        );
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewTheEditRolePage()
    {
        $response = $this->getJson(route('roles.edit', $this->role));
        $response->assertUnauthorized();
    }

    /** @test **/
    public function unauthenticatedUserCannotUpdateRole()
    {
        $response = $this->putJson(
            route('roles.update', $this->role),
            make(Role::class)->toArray()
        );
        $response->assertUnauthorized();
    }

    /** @test **/
    public function lockedRoleKeyCannotBeUpdated()
    {
        $role = create(Role::class, [], ['locked']);

        $this->signInWithPermission('role.update');

        $response = $this->put(route('roles.update', $role), [
            'display_name' => 'Foo',
            'name' => 'foo',
            'default' => false,
        ]);

        $this->assertDatabaseHas('roles', [
            'id' => $role->id,
            'display_name' => 'Foo',
            'name' => $role->name,
            'locked' => true,
        ]);
    }

    /** @test **/
    public function roleCanBeRevokedFromUser()
    {
        $this->signInWithPermission('role.update');

        $user = create(User::class);
        $user->attachRole($this->role);

        $this->assertTrue($user->hasRole($this->role->name));

        $response = $this->put(route('roles.update', $this->role), [
            'id' => $this->role->id,
            'name' => $this->role->name,
            'display_name' => $this->role->display_name,
            'users' => [],
            'default' => false,
        ]);

        $this->followRedirects($response)->assertSuccessful();

        $this->assertFalse($user->refresh()->hasRole($this->role->name));
    }

    /** @test **/
    public function roleCanBeGivenToUser()
    {
        $this->signInWithPermission('role.update');

        $user = create(User::class);

        $this->assertFalse($user->hasRole($this->role->name));

        $response = $this->put(route('roles.update', $this->role), [
            'id' => $this->role->id,
            'name' => $this->role->name,
            'display_name' => $this->role->display_name,
            'users' => [$user->id],
            'default' => false,
        ]);

        $this->followRedirects($response)->assertSuccessful();

        $this->assertTrue($user->refresh()->hasRole($this->role->name));
    }
}
