<?php

namespace Tests\Feature\Roles;

use Tests\TestCase;
use Nova\Roles\Models\Role;
use Nova\Roles\Events\RoleCreated;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateRoleTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function authorizedUserCanCreateRole()
    {
        $this->signInWithPermission('role.create');

        $response = $this->get(route('roles.create'));
        $response->assertSuccessful();

        $roleData = factory(Role::class)->make();

        $postData = array_merge($roleData->toArray(), [
            'permissions' => ['foo', 'bar', 'baz'],
            'users' => [],
        ]);

        $this->followingRedirects();

        $response = $this->post(route('roles.store'), $postData);

        $response->assertSuccessful();

        $role = Role::get()->last();

        $this->assertCount(3, $role->permissions);

        $this->assertDatabaseHas('roles', [
            'name' => $roleData->name,
            'display_name' => $roleData->display_name,
        ]);
    }

    /** @test **/
    public function unauthorizedUserCannotCreateRole()
    {
        $this->signIn();

        $response = $this->get(route('roles.create'));
        $response->assertForbidden();

        $response = $this->post(route('roles.store'), []);
        $response->assertForbidden();
    }

    /** @test **/
    public function guestCannotCreateRole()
    {
        $response = $this->get(route('roles.create'));
        $response->assertRedirect(route('login'));

        $response = $this->post(route('roles.store'), []);
        $response->assertRedirect(route('login'));
    }

    /** @test **/
    public function eventIsDispatchedWhenRoleIsCreated()
    {
        Event::fake();

        $this->signInWithPermission('role.create');

        $data = array_merge(factory(Role::class)->make()->toArray(), [
            'permissions' => ['foo', 'bar', 'baz'],
            'users' => [],
        ]);

        $this->post(route('roles.store'), $data);

        $role = Role::get()->last();

        Event::assertDispatched(RoleCreated::class, function ($event) use ($role) {
            return $event->role->is($role);
        });
    }

    /** @test **/
    public function nameIsRequiredToCreateRole()
    {
        $this->signInWithPermission('role.create');

        $response = $this->post(route('roles.store'), [
            'display_name' => 'Foo',
        ]);

        $response->assertSessionHasErrors('name');
    }

    /** @test **/
    public function nameMustBeUnique()
    {
        $role = factory(Role::class)->create();

        $this->signInWithPermission('role.create');

        $response = $this->post(route('roles.store'), [
            'name' => $role->name,
            'display_name' => 'display_name',
        ]);

        $response->assertSessionHasErrors('name');
    }

    /** @test **/
    public function displayNameIsRequiredToCreateRole()
    {
        $this->signInWithPermission('role.create');

        $response = $this->post(route('roles.store'), [
            'name' => 'foo',
        ]);

        $response->assertSessionHasErrors('display_name');
    }

    /** @test **/
    public function roleCanBeGivenToUser()
    {
        $this->signInWithPermission('role.create');

        $user = $this->createUser();

        $role = factory(Role::class)->make();

        $data = array_merge($role->toArray(), [
            'permissions' => [],
            'users' => [$user->id],
        ]);

        $this->post(route('roles.store'), $data);

        $this->assertTrue($user->hasRole($role->name));
    }

    /** @test **/
    public function activityIsLoggedWhenRoleIsCreated()
    {
        $role = factory(Role::class)->create();

        $this->assertDatabaseHas('activity_log', [
            'description' => $role->display_name . ' role was created',
        ]);
    }
}
