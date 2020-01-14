<?php

namespace Tests\Feature\Roles;

use Tests\TestCase;
use Nova\Roles\Models\Role;
use Illuminate\Http\Response;
use Nova\Roles\Models\Permission;
use Illuminate\Support\Facades\Event;
use Nova\Roles\Events\RoleDuplicated;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DuplicateRoleTest extends TestCase
{
    use RefreshDatabase;

    protected $role;

    public function setUp(): void
    {
        parent::setUp();

        $this->role = Role::firstOrCreate([
            'name' => 'foo',
            'display_name' => 'Foo',
        ]);
    }

    public function testAuthorizedUserCanDuplicateRole()
    {
        $this->signInWithPermission('role.create');

        $this->postJson(route('roles.duplicate', $this->role))
            ->assertSuccessful();
    }

    public function testUnauthorizedUserCannotDuplicateRole()
    {
        $this->signIn();

        $this->postJson(route('roles.duplicate', $this->role))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testGuestCannotDuplicateRole()
    {
        $this->postJson(route('roles.duplicate', $this->role))
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testRoleCanBeDuplicated()
    {
        $this->signInWithPermission('role.create');

        $originalPermission = Permission::firstOrCreate([
            'name' => 'bar',
        ]);

        $this->role->attachPermission($originalPermission);

        $this->postJson(route('roles.duplicate', $this->role))
            ->assertSuccessful();

        $role = Role::get()->last();

        $this->assertDatabaseHas('roles', [
            'display_name' => "Copy of {$this->role->display_name}",
        ]);

        $this->assertCount(1, $this->role->permissions);
        $this->assertCount(1, $role->permissions);
    }

    public function testEventIsDispatchedWhenRoleIsDuplicated()
    {
        Event::fake();

        $this->signInWithPermission('role.create');

        $originalRole = Role::firstOrCreate([
            'name' => 'foo',
        ]);

        $this->postJson(route('roles.duplicate', $this->role));

        $role = Role::get()->last();

        Event::assertDispatched(RoleDuplicated::class, function ($event) use ($role, $originalRole) {
            return $event->role->is($role) && $event->originalRole->is($originalRole);
        });
    }
}
