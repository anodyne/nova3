<?php

namespace Tests\Feature\Themes;

use Tests\TestCase;
use Nova\Authorization\Events;
use Silber\Bouncer\Database\Role;
use Silber\Bouncer\Database\Ability;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateRolesTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanViewCreateRolePage()
    {
        $this->signInWithAbility('role.create');

        $this->get(route('roles.create'))
            ->assertSuccessful();
    }

    public function testUnauthorizedUserCannotCreateRole()
    {
        $this->get(route('roles.create'))->assertRedirect(route('login'));
        $this->post(route('roles.store'), [])->assertRedirect(route('login'));
    }

    public function testRoleCanBeCreated()
    {
        $this->signInWithAbility('role.create');

        $data = array_merge(
            factory(Role::class)->make()->toArray(),
            factory(Ability::class)->make()->toArray()
        );

        $this->followingRedirects()
            ->from(route('roles.create'))
            ->post(route('roles.store'), $this->roleData)
            ->assertSuccessful();

        $this->assertDatabaseHas('roles', $this->roleData);
    }

    public function testRoleCanBeCreatedWithExistingRoleData()
    {
        $this->signInWithAbility('role.create');

        $originalRole = Role::first();

        $data = array_merge($this->roleData, $originalRole->getAbilities());

        $this->post(route('roles.store'), $data);

        $role = Role::get()->last();
    }

    public function testEventIsDispatchedWhenRoleIsCreated()
    {
        Event::fake();

        $this->signInWithAbility('role.create');

        $this->post(route('roles.store'), factory(Role::class)->make()->toArray());

        $role = Role::get()->last();

        Event::assertDispatched(Events\RoleCreated::class, function ($event) use ($role) {
            return $event->role->is($role);
        });
    }
}
