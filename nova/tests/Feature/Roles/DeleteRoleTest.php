<?php

declare(strict_types=1);

namespace Tests\Feature\Roles;

use Illuminate\Support\Facades\Event;
use Nova\Roles\Events\RoleDeleted;
use Nova\Roles\Models\Role;
use Nova\Users\Models\User;
use Tests\TestCase;

/**
 * @group roles
 */
class DeleteRoleTest extends TestCase
{
    protected $role;

    public function setUp(): void
    {
        parent::setUp();

        $this->disableRoleCaching();

        $this->role = Role::factory()->create();
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

        $user = User::factory()->active()->create();
        $user->addRole($this->role->name);

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

        $role = Role::factory()->locked()->create();

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
