<?php

namespace Tests\Feature\Roles;

use Tests\TestCase;
use Nova\Roles\Models\Role;
use Nova\Roles\Models\Ability;
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
        $this->signInWithAbility('role.update');

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
        $this->signInWithAbility('role.update');

        $data = [
            'id' => $this->role->id,
            'name' => 'new-name',
            'title' => 'New title',
            'abilities' => ['foo'],
            'users' => [],
        ];

        $this->assertCount(0, $this->role->getAbilities());

        $response = $this->putJson(route('roles.update', $this->role), $data);
        $response->assertSuccessful();

        $this->assertDatabaseHas('roles', [
            'name' => 'new-name',
            'title' => 'New title',
        ]);

        $this->assertDatabaseHas('abilities', ['name' => 'foo']);

        $this->assertDatabaseHas('permissions', [
            'ability_id' => Ability::get()->last()->id,
            'entity_id' => $this->role->id,
        ]);
    }

    /** @test **/
    public function lockedRoleCannotBeUpdated()
    {
        $role = factory(Role::class)->states('locked')->create();

        $this->signInWithAbility('role.update');

        $response = $this->putJson(route('roles.update', $role), [
            'title' => 'Foo',
        ]);

        $response->assertForbidden();

        $this->assertDatabaseHas('roles', [
            'name' => $role->name,
            'title' => $role->title,
        ]);
    }

    /** @test **/
    public function eventIsDispatchedWhenRoleIsUpdated()
    {
        Event::fake();

        $this->signInWithAbility('role.update');

        $data = [
            'id' => $this->role->id,
            'name' => 'new-name',
            'title' => 'New title',
            'abilities' => ['foo', 'bar', 'baz'],
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
        $this->signInWithAbility('role.update');

        $user = $this->createUser();
        $user->assign($this->role);

        $this->assertTrue($user->isA($this->role));

        $response = $this->putJson(route('roles.update', $this->role), [
            'id' => $this->role->id,
            'name' => $this->role->name,
            'title' => $this->role->title,
            'users' => [],
        ]);

        $response->assertSuccessful();

        $this->assertFalse($user->refresh()->isA($this->role));
    }

    /** @test **/
    public function roleCanBeGivenToUser()
    {
        $this->signInWithAbility('role.update');

        $user = $this->createUser();

        $this->assertFalse($user->isA($this->role));

        $response = $this->putJson(route('roles.update', $this->role), [
            'id' => $this->role->id,
            'name' => $this->role->name,
            'title' => $this->role->title,
            'users' => [$user->id],
        ]);

        $response->assertSuccessful();

        $this->assertTrue($user->isA($this->role));
    }
}
