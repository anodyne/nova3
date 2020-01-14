<?php

namespace Tests\Feature\Roles;

use Tests\TestCase;
use Nova\Roles\Models\Role;
use Nova\Roles\Models\Permission;
use Nova\Roles\Events\RoleUpdated;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateRoleTest extends TestCase
{
    use RefreshDatabase;

    protected $role;

    public function setUp(): void
    {
        parent::setUp();

        $this->role = factory(Role::class)->create();
    }

    /** @test **/
    public function authorizedUserCanUpdateRole()
    {
        $this->signInWithPermission('role.update');

        $response = $this->get(route('roles.edit', $this->role));
        $response->assertSuccessful();
    }

    /** @test **/
    public function unauthorizedUserCannotUpdateRole()
    {
        $this->signIn();

        $response = $this->get(route('roles.edit', $this->role));
        $response->assertForbidden();

        $response = $this->putJson(route('roles.update', $this->role), []);
        $response->assertForbidden();
    }

    /** @test **/
    public function guestCannotUpdateRole()
    {
        $response = $this->get(route('roles.edit', $this->role));
        $response->assertRedirect(route('login'));

        $response = $this->putJson(route('roles.update', $this->role), []);
        $response->assertUnauthorized();
    }

    /** @test **/
    public function roleCanBeUpdated()
    {
        $this->signInWithPermission('role.update');

        $data = [
            'id' => $this->role->id,
            'name' => 'new-name',
            'display_name' => 'New display name',
            'permissions' => ['foo'],
            'users' => [],
        ];

        $this->assertCount(0, $this->role->permissions);

        $response = $this->putJson(route('roles.update', $this->role), $data);
        $response->assertSuccessful();

        $this->assertDatabaseHas('roles', [
            'name' => 'new-name',
            'display_name' => 'New display name',
        ]);

        $this->assertDatabaseHas('permissions', ['name' => 'foo']);

        $this->assertDatabaseHas('permission_role', [
            'permission_id' => Permission::get()->last()->id,
            'role_id' => $this->role->id,
        ]);
    }

    /** @test **/
    public function lockedRoleCannotBeUpdated()
    {
        $role = factory(Role::class)->states('locked')->create();

        $this->signInWithPermission('role.update');

        $response = $this->putJson(route('roles.update', $role), [
            'display_name' => 'Foo',
        ]);

        $response->assertForbidden();

        $this->assertDatabaseHas('roles', [
            'name' => $role->name,
            'display_name' => $role->display_name,
        ]);
    }

    /** @test **/
    public function eventIsDispatchedWhenRoleIsUpdated()
    {
        Event::fake();

        $this->signInWithPermission('role.update');

        $data = [
            'id' => $this->role->id,
            'name' => 'new-name',
            'display_name' => 'New display name',
            'permissions' => ['foo', 'bar', 'baz'],
            'users' => [],
        ];

        $this->putJson(route('roles.update', $this->role), $data);

        $role = $this->role->refresh();

        Event::assertDispatched(RoleUpdated::class, function ($event) use ($role) {
            return $event->role->is($role);
        });
    }

    /** @test **/
    public function roleCanBeRevokedFromUser()
    {
        $this->signInWithPermission('role.update');

        $user = $this->createUser();
        $user->attachRole($this->role);

        $this->assertTrue($user->hasRole($this->role->name));

        $response = $this->putJson(route('roles.update', $this->role), [
            'id' => $this->role->id,
            'name' => $this->role->name,
            'display_name' => $this->role->display_name,
            'users' => [],
        ]);

        $response->assertSuccessful();

        $this->assertFalse($user->refresh()->hasRole($this->role->name));
    }

    /** @test **/
    public function roleCanBeGivenToUser()
    {
        $this->signInWithPermission('role.update');

        $user = $this->createUser();

        $this->assertFalse($user->hasRole($this->role->name));

        $response = $this->putJson(route('roles.update', $this->role), [
            'id' => $this->role->id,
            'name' => $this->role->name,
            'display_name' => $this->role->display_name,
            'users' => [$user->id],
        ]);

        $response->assertSuccessful();

        $this->assertTrue($user->hasRole($this->role->name));
    }
}
