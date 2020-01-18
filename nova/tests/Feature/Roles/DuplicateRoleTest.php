<?php

namespace Tests\Feature\Roles;

use Tests\TestCase;
use Nova\Roles\Models\Role;
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

    /** @test **/
    public function authorizedUserCanDuplicateRole()
    {
        $this->signInWithPermission(['role.create', 'role.update']);

        $originalPermission = Permission::firstOrCreate([
            'name' => 'bar',
        ]);

        $this->role->attachPermission($originalPermission);

        $response = $this->post(route('roles.duplicate', $this->role));

        $this->followRedirects($response)->assertSuccessful();

        $role = Role::get()->last();

        $this->assertCount(1, $this->role->permissions);
        $this->assertCount(1, $role->permissions);

        $this->assertDatabaseHas('roles', [
            'display_name' => "Copy of {$this->role->display_name}",
        ]);
    }

    /** @test **/
    public function unauthorizedUserCannotDuplicateRole()
    {
        $this->signIn();

        $response = $this->post(route('roles.duplicate', $this->role));

        $response->assertForbidden();
    }

    /** @test **/
    public function guestCannotDuplicateRole()
    {
        $response = $this->post(route('roles.duplicate', $this->role));

        $response->assertRedirect(route('login'));
    }

    /** @test **/
    public function eventIsDispatchedWhenRoleIsDuplicated()
    {
        Event::fake();

        $this->signInWithPermission(['role.create', 'role.update']);

        $originalRole = Role::firstOrCreate([
            'name' => 'foo',
        ]);

        $this->post(route('roles.duplicate', $this->role));

        $role = Role::get()->last();

        Event::assertDispatched(RoleDuplicated::class, function ($event) use ($role, $originalRole) {
            return $event->role->is($role) && $event->originalRole->is($originalRole);
        });
    }
}
