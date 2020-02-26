<?php

namespace Tests\Feature\Roles;

use Tests\TestCase;
use Nova\Roles\Models\Role;
use Nova\Roles\Events\RoleDeleted;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @see \Nova\Roles\Http\Controllers\RoleController
 */
class DeleteRoleTest extends TestCase
{
    use RefreshDatabase;

    protected $role;

    public function setUp(): void
    {
        parent::setUp();

        $this->role = factory(Role::class)->create();
    }

    /** @test **/
    public function authorizedUserCanDeleteRole()
    {
        $this->signInWithPermission('role.delete');

        $response = $this->delete(route('roles.destroy', $this->role));

        $this->followRedirects($response)->assertSuccessful();

        $this->assertDatabaseMissing('roles', [
            'id' => $this->role->id,
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
    public function guestCannotDeleteRole()
    {
        $response = $this->delete(route('roles.destroy', $this->role));

        $response->assertRedirect(route('login'));
    }

    /** @test **/
    public function lockedRoleCannotBeDeleted()
    {
        $role = factory(Role::class)->states('locked')->create();

        $this->signInWithPermission('role.delete');

        $response = $this->delete(route('roles.destroy', $role));
        $response->assertForbidden();

        $this->assertDatabaseHas('roles', [
            'id' => $role->id,
            'locked' => true,
        ]);
    }

    /** @test **/
    public function eventIsDispatchedWhenRoleIsDeleted()
    {
        Event::fake();

        $this->signInWithPermission('role.delete');

        $this->delete(route('roles.destroy', $this->role));

        Event::assertDispatched(RoleDeleted::class, function ($event) {
            return $event->role->is($this->role);
        });
    }

    /** @test **/
    public function usersWithRoleThatHasBeenDeletedHaveThatRoleRemoved()
    {
        $user = $this->createUser();
        $user->attachRole($this->role->name);

        $this->signInWithPermission('role.delete');

        $this->delete(route('roles.destroy', $this->role));

        $this->assertCount(0, $user->roles);
    }

    /** @test **/
    public function activityIsLoggedWhenRoleIsDeleted()
    {
        $this->role->delete();

        $this->assertDatabaseHas('activity_log', [
            'description' => $this->role->display_name . ' role was deleted',
        ]);
    }
}
