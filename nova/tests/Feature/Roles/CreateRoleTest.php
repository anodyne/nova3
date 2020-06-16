<?php

namespace Tests\Feature\Roles;

use Tests\TestCase;
use Nova\Roles\Models\Role;
use Nova\Users\Models\User;
use Nova\Roles\Events\RoleCreated;
use Illuminate\Support\Facades\Event;
use Nova\Roles\Http\Requests\CreateRoleRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group roles
 */
class CreateRoleTest extends TestCase
{
    use RefreshDatabase;

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

        $role = make(Role::class);

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

        $role = make(Role::class, [], ['default']);

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
    public function roleCanBeCreatedWithPermissions()
    {
        $this->signInWithPermission('role.create');

        $role = make(Role::class);

        $this->followingRedirects();

        $response = $this->post(
            route('roles.store'),
            array_merge($role->toArray(), [
                'permissions' => [1],
            ])
        );
        $response->assertSuccessful();

        $this->assertDatabaseHas('permission_role', [
            'permission_id' => 1,
            'role_id' => Role::latest()->first()->id,
        ]);
    }

    /** @test **/
    public function roleCanBeCreatedWithUsers()
    {
        $this->signInWithPermission('role.create');

        $role = make(Role::class, [], ['default']);

        $john = create(User::class);

        $this->followingRedirects();

        $response = $this->post(
            route('roles.store'),
            array_merge($role->toArray(), [
                'users' => [$john->id],
            ])
        );
        $response->assertSuccessful();

        $this->assertDatabaseHas('role_user', [
            'user_id' => $john->id,
            'role_id' => Role::latest()->first()->id,
        ]);
    }

    /** @test **/
    public function eventIsDispatchedWhenRoleIsCreated()
    {
        Event::fake();

        $this->signInWithPermission('role.create');

        $this->post(route('roles.store'), make(Role::class)->toArray());

        Event::assertDispatched(RoleCreated::class);
    }

    /** @test **/
    public function activityIsLoggedWhenRoleIsCreated()
    {
        $role = create(Role::class);

        $this->assertDatabaseHas('activity_log', [
            'description' => $role->display_name . ' role was created',
        ]);
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
            make(Role::class)->toArray()
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
            make(Role::class)->toArray()
        );
        $response->assertUnauthorized();
    }
}
