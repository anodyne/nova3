<?php

namespace Tests\Feature\Roles;

use Tests\TestCase;
use Nova\Roles\Models\Role;
use Nova\Users\Models\User;
use Nova\Roles\Events\RoleUpdated;
use Illuminate\Support\Facades\Event;
use Nova\Roles\Http\Requests\UpdateRoleRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @see \Nova\Roles\Http\Controllers\RoleController
 */
class UpdateRoleTest extends TestCase
{
    use RefreshDatabase;

    protected $role;

    public function setUp(): void
    {
        parent::setUp();

        $this->role = create(Role::class);

        config(['laratrust.cache.enabled' => false]);
    }

    /** @test **/
    public function authorizedUserCanUpdateRole()
    {
        $this->signInWithPermission('role.update');

        $response = $this->get(route('roles.edit', $this->role));
        $response->assertSuccessful();

        $data = make(Role::class, [
            'id' => $this->role->id,
            'name' => 'new-name',
            'display_name' => 'New display name',
            'permissions' => [1],
        ])->toArray();

        $this->assertCount(0, $this->role->permissions);

        $response = $this->put(route('roles.update', $this->role), $data);

        $this->followRedirects($response)->assertSuccessful();

        $this->assertDatabaseHas('roles', [
            'name' => 'new-name',
            'display_name' => 'New display name',
        ]);
    }

    /** @test **/
    public function unauthorizedUserCannotUpdateRole()
    {
        $this->signIn();

        $response = $this->get(route('roles.edit', $this->role));
        $response->assertForbidden();

        $response = $this->putJson(
            route('roles.update', $this->role),
            make(Role::class)->toArray()
        );
        $response->assertForbidden();
    }

    /** @test **/
    public function guestCannotUpdateRole()
    {
        $response = $this->get(route('roles.edit', $this->role));
        $response->assertRedirect(route('login'));

        $response = $this->put(route('roles.update', $this->role), []);
        $response->assertRedirect(route('login'));
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
    public function eventIsDispatchedWhenRoleIsUpdated()
    {
        Event::fake();

        $this->signInWithPermission('role.update');

        $this->withoutExceptionHandling();

        $data = [
            'id' => $this->role->id,
            'name' => 'new-name',
            'display_name' => 'New display name',
            'permissions' => [1, 2, 3],
            'users' => [],
            'default' => false,
        ];

        $this->put(route('roles.update', $this->role), $data);

        $role = $this->role->refresh();

        Event::assertDispatched(RoleUpdated::class, function ($event) use ($role) {
            return $event->role->is($role);
        });
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

    /** @test **/
    public function activityIsLoggedWhenRoleIsUpdated()
    {
        $this->role->update([
            'display_name' => 'Foo',
        ]);

        $this->assertDatabaseHas('activity_log', [
            'description' => $this->role->display_name . ' role was updated',
        ]);
    }

    /** @test **/
    public function updatingRoleInDatabaseUsesFormRequest()
    {
        $this->assertRouteUsesFormRequest(
            'roles.update',
            UpdateRoleRequest::class
        );
    }
}
