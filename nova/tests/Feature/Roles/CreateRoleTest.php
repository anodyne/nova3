<?php

declare(strict_types=1);

namespace Tests\Feature\Roles;

use Illuminate\Support\Facades\Event;
use Nova\Roles\Events\RoleCreated;
use Nova\Roles\Models\Role;
use Nova\Roles\Requests\CreateRoleRequest;
use Tests\TestCase;

/**
 * @group roles
 */
class CreateRoleTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->disableRoleCaching();
    }

    /** @test **/
    public function authorizedUserCanViewTheCreateRolePage()
    {
        $this->signInWithPermission('role.create');

        $response = $this->get(route('roles.create'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserCanCreateRole()
    {
        $this->signInWithPermission('role.create');

        $role = Role::factory()->make();

        $this->followingRedirects();

        $response = $this->post(route('roles.store'), $role->toArray());
        $response->assertSuccessful();

        $this->assertDatabaseHas('roles', $role->only('name', 'display_name'));

        $this->assertRouteUsesFormRequest(
            'roles.store',
            CreateRoleRequest::class
        );
    }

    /** @test **/
    public function roleCanBeCreatedAsADefaultRoleForNewUsers()
    {
        $this->signInWithPermission('role.create');

        $role = Role::factory()->default()->make();

        $this->followingRedirects();

        $response = $this->post(route('roles.store'), $role->toArray());
        $response->assertSuccessful();

        $this->assertTrue(
            Role::whereDefault()->get()->contains('name', $role->name)
        );

        $this->assertDatabaseHas(
            'roles',
            $role->only('name', 'display_name', 'default')
        );
    }

    /** @test **/
    public function eventIsDispatchedWhenRoleIsCreated()
    {
        Event::fake();

        $this->signInWithPermission('role.create');

        $this->post(route('roles.store'), Role::factory()->make()->toArray());

        Event::assertDispatched(RoleCreated::class);
    }

    /** @test **/
    public function unauthorizedUserCannotViewTheCreateRolePage()
    {
        $this->signIn();

        $response = $this->get(route('roles.create'));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthorizedUserCannotCreateRole()
    {
        $this->signIn();

        $response = $this->postJson(
            route('roles.store'),
            Role::factory()->make()->toArray()
        );
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewTheCreateRolePage()
    {
        $response = $this->getJson(route('roles.create'));
        $response->assertUnauthorized();
    }

    /** @test **/
    public function unauthenticatedUserCannotCreateRole()
    {
        $response = $this->postJson(
            route('roles.store'),
            Role::factory()->make()->toArray()
        );
        $response->assertUnauthorized();
    }
}
