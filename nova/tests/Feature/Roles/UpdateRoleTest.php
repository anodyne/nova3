<?php

declare(strict_types=1);

namespace Tests\Feature\Roles;

use Illuminate\Support\Facades\Event;
use Nova\Roles\Events\RoleUpdated;
use Nova\Roles\Models\Permission;
use Nova\Roles\Models\Role;
use Nova\Roles\Requests\UpdateRoleRequest;
use Nova\Users\Models\User;
use Tests\TestCase;

/**
 * @group roles
 */
class UpdateRoleTest extends TestCase
{
    protected $role;

    public function setUp(): void
    {
        parent::setUp();

        $this->disableRoleCaching();

        $this->role = Role::factory()->create();
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
    }

    /** @test **/
    public function permissionsCanBeAddedToARole()
    {
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

        $this->assertTrue($this->role->refresh()->user->contains('id', $john->id));
        $this->assertTrue($this->role->user->contains('id', $jane->id));

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

        $this->assertFalse($this->role->refresh()->user->contains('id', $john->id));
        $this->assertTrue($this->role->user->contains('id', $jane->id));

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
            Role::factory()->make()->toArray()
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
            Role::factory()->make()->toArray()
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
            Role::factory()->make()->toArray()
        );
        $response->assertUnauthorized();
    }

    /** @test **/
    public function lockedRoleKeyCannotBeUpdated()
    {
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
    }

    /** @test **/
    public function roleCanBeRevokedFromUser()
    {
        $this->markTestSkipped('Need to test Livewire component');

        $this->signInWithPermission('role.update');

        $user = User::factory()->active()->create();
        $user->addRole($this->role);

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
        $this->markTestSkipped('Need to test Livewire component');

        $this->signInWithPermission('role.update');

        $user = User::factory()->active()->create();

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
