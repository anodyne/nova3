<?php

namespace Tests\Feature\Roles;

use Tests\TestCase;
use Nova\Roles\Events;
use Nova\Roles\Models\Role;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteRoleTest extends TestCase
{
    use RefreshDatabase;

    protected $role;

    public function setUp(): void
    {
        parent::setUp();

        $this->role = factory(Role::class)->create();
    }

    public function testAuthorizedUserCanDeleteRole()
    {
        $this->signInWithAbility('role.delete');

        $this->deleteJson(route('roles.destroy', $this->role))
            ->assertSuccessful();
    }

    public function testUnauthorizedUserCannotDeleteRole()
    {
        $this->signIn();

        $this->deleteJson(route('roles.destroy', $this->role))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testGuestCannotDeleteRole()
    {
        $this->deleteJson(route('roles.destroy', $this->role))
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testRoleCanBeDeleted()
    {
        $this->signInWithAbility('role.delete');

        $this->deleteJson(route('roles.destroy', $this->role))
            ->assertSuccessful();

        $this->assertDatabaseMissing('roles', [
            'id' => $this->role->id,
        ]);
    }

    public function testLockedRoleCannotBeDeleted()
    {
        $role = factory(Role::class)->states('locked')->create();

        $this->signInWithAbility('role.delete');

        $this->deleteJson(route('roles.destroy', $role))
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseHas('roles', [
            'name' => $role->name,
            'title' => $role->title,
            'locked' => true,
        ]);
    }

    public function testEventIsDispatchedWhenRoleIsDeleted()
    {
        Event::fake();

        $this->signInWithAbility('role.delete');

        $this->deleteJson(route('roles.destroy', $this->role));

        Event::assertDispatched(Events\Deleted::class, function ($event) {
            return $event->role->is($this->role);
        });
    }

    public function testUsersWithRoleThatHasBeenDeletedHaveThatRoleRemoved()
    {
        $role = factory(Role::class)->create();

        $user = $this->createUser();
        $user->assign($role);

        $this->signInWithAbility('role.delete');

        $this->deleteJson(route('roles.destroy', $role));

        $this->assertCount(0, $user->getRoles());
    }
}
