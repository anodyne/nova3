<?php

namespace Tests\Feature\Themes;

use Tests\TestCase;
use Nova\Authorization\Events;
use Silber\Bouncer\Database\Role;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageRolesTest extends TestCase
{
    use RefreshDatabase;

    protected $role;

    public function setUp(): void
    {
        parent::setUp();

        $this->role = factory(Role::class)->create();
    }

    public function testUserCanViewManageRolesPage()
    {
        $this->signInWithAbility('role.create');

        $this->get(route('roles.index'))
            ->assertSuccessful();
    }

    public function testUserCanViewEditRolePage()
    {
        $this->signInWithAbility('role.update');

        $this->get(route('roles.edit', $this->role))
            ->assertSuccessful();
    }

    public function testARoleCanBeUpdated()
    {
        $this->signInWithAbility('role.update');

        $data = [
            'name' => 'new-name',
            'title' => 'New title',
        ];

        $this->followingRedirects()
            ->from(route('roles.edit', $this->role))
            ->patch(route('roles.update', $this->role), $data)
            ->assertSuccessful();

        $this->assertDatabaseHas('roles', $data);
    }

    public function testAnEventIsDispatchedWhenARoleIsUpdated()
    {
        Event::fake();

        $this->signInWithAbility('role.update');

        $data = [
            'name' => 'new-name',
            'title' => 'New title',
        ];

        $this->patch(route('roles.update', $this->role), $data);

        $role = $this->role->fresh();

        Event::assertDispatched(Events\RoleUpdated::class, function ($event) use ($role) {
            return $event->role->is($role);
        });
    }

    public function testARoleCanBeDeleted()
    {
        $this->signInWithAbility('role.delete');

        $this->deleteJson(route('roles.destroy', $this->role))
            ->assertSuccessful();

        $this->assertDatabaseMissing('roles', [
            'id' => $this->role->id,
        ]);
    }

    public function testAnEventIsDispatchedWhenARoleIsDeleted()
    {
        Event::fake();

        $this->signInWithAbility('role.delete');

        $this->delete(route('roles.destroy', $this->role));

        Event::assertDispatched(Events\RoleDeleted::class, function ($event) {
            return $event->role->is($this->role);
        });
    }

    public function testUsersWithARoleThatHasBeenDeletedHaveThatRoleRemoved()
    {
        $role = factory(Role::class)->create();

        $user = $this->createUser();
        $user->assign($role->name);

        $this->signInWithAbility('role.delete');

        $this->delete(route('roles.destroy', $role));

        $this->assertCount(0, $user->getRoles());
    }

    public function testUnauthorizedUsersCannotManageRoles()
    {
        $redirectRoute = route('login');

        $this->get(route('roles.index'))->assertRedirect($redirectRoute);
        $this->get(route('roles.create'))->assertRedirect($redirectRoute);
        $this->get(route('roles.edit', $this->role))->assertRedirect($redirectRoute);
        $this->post(route('roles.store'), [])->assertRedirect($redirectRoute);
        $this->patch(route('roles.update', $this->role), [])->assertRedirect($redirectRoute);
        $this->delete(route('roles.destroy', $this->role), [])->assertRedirect($redirectRoute);
    }
}
