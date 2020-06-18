<?php

namespace Tests\Feature\Roles;

use Tests\TestCase;
use Nova\Roles\Models\Role;
use Nova\Users\Models\User;
use Nova\Roles\Events\RoleDeleted;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group roles
 */
class DeleteRoleTest extends TestCase
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
    public function authorizedUserCanDeleteRole()
    {
        $this->signInWithPermission('role.delete');

        $this->followingRedirects();

        $response = $this->delete(route('roles.destroy', $this->role));
        $response->assertSuccessful();

        $this->assertDatabaseMissing('roles', [
            'id' => $this->role->id,
        ]);
    }

    /** @test **/
    public function usersWithRoleThatHasBeenDeletedHaveThatRoleRemovedFromTheirRoles()
    {
        $this->signInWithPermission('role.delete');

        $user = create(User::class, [], ['status:active']);
        $user->attachRole($this->role->name);

        $this->delete(route('roles.destroy', $this->role));

        $this->assertCount(0, $user->refresh()->roles);
        $this->assertFalse($user->hasRole($this->role->name));
    }

    /** @test **/
    public function eventIsDispatchedWhenRoleIsDeleted()
    {
        Event::fake();

        $this->signInWithPermission('role.delete');

        $this->delete(route('roles.destroy', $this->role));

        Event::assertDispatched(RoleDeleted::class);
    }

    /** @test **/
    public function lockedRoleCannotBeDeleted()
    {
        $this->signInWithPermission('role.delete');

        $role = create(Role::class, [], ['locked']);

        $response = $this->delete(route('roles.destroy', $role));
        $response->assertForbidden();

        $this->assertDatabaseHas('roles', [
            'id' => $role->id,
            'locked' => true,
        ]);
    }

    /** @test **/
    public function unauthorizedUserCannotDeleteRole()
    {
        $this->signIn();

        $response = $this->delete(route('roles.destroy', $this->role));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotDeleteRole()
    {
        $response = $this->deleteJson(route('roles.destroy', $this->role));
        $response->assertUnauthorized();
    }
}
