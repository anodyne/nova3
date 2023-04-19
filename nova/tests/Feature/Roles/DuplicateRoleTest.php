<?php

declare(strict_types=1);

namespace Tests\Feature\Roles;

use Illuminate\Support\Facades\Event;
use Nova\Roles\Events\RoleDuplicated;
use Nova\Roles\Models\Permission;
use Nova\Roles\Models\Role;
use Tests\TestCase;

/**
 * @group roles
 */
class DuplicateRoleTest extends TestCase
{
    protected $role;

    public function setUp(): void
    {
        parent::setUp();

        $this->disableRoleCaching();

        $this->role = Role::factory()->create([
            'name' => 'foo',
            'display_name' => 'Foo',
        ]);
    }

    /** @test **/
    public function authorizedUserCanDuplicateRole()
    {
        $this->signInWithPermission(['role.create', 'role.update']);

        $this->role->givePermission($permission = Permission::first());

        $this->followingRedirects();

        $response = $this->post(route('roles.duplicate', $this->role));
        $response->assertSuccessful();

        $role = Role::get()->last();

        $this->assertCount(1, $this->role->refresh()->permissions);
        $this->assertCount(1, $role->permissions);
        $this->assertTrue($role->hasPermission($permission->name));

        $this->assertDatabaseHas('roles', [
            'display_name' => "Copy of {$this->role->display_name}",
        ]);
    }

    /** @test **/
    public function eventIsDispatchedWhenRoleIsDuplicated()
    {
        Event::fake();

        $this->signInWithPermission(['role.create', 'role.update']);

        $this->post(route('roles.duplicate', $this->role));

        Event::assertDispatched(RoleDuplicated::class);
    }

    /** @test **/
    public function lockedRoleCannotBeDuplicated()
    {
        $role = Role::factory()->locked()->create();

        $this->signInWithPermission(['role.create', 'role.update']);

        $roleCount = Role::count();

        $response = $this->postJson(route('roles.duplicate', $role));
        $response->assertForbidden();

        $this->assertEquals($roleCount, Role::count());
    }

    /** @test **/
    public function unauthorizedUserCannotDuplicateRole()
    {
        $this->signIn();

        $response = $this->post(route('roles.duplicate', $this->role));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotDuplicateRole()
    {
        $response = $this->postJson(route('roles.duplicate', $this->role));
        $response->assertUnauthorized();
    }
}
