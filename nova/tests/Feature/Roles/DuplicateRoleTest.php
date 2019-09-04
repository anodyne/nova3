<?php

namespace Tests\Feature\Roles;

use Bouncer;
use Tests\TestCase;
use Nova\Roles\Models\Role;
use Illuminate\Http\Response;
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

        $this->role = Bouncer::role()->firstOrCreate([
            'name' => 'foo',
            'title' => 'Foo',
        ]);
    }

    public function testAuthorizedUserCanDuplicateRole()
    {
        $this->withoutExceptionHandling();
        $this->signInWithAbility('role.create');

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
        $this->signInWithAbility('role.create');

        $originalAbility = Bouncer::ability()->firstOrCreate([
            'name' => 'bar',
        ]);

        Bouncer::allow($this->role)->to($originalAbility);

        $this->postJson(route('roles.duplicate', $this->role))
            ->assertSuccessful();

        $role = Role::get()->last();

        $this->assertDatabaseHas('roles', [
            'title' => "Copy of {$this->role->title}",
        ]);

        $this->assertCount(1, $this->role->getAbilities());
        $this->assertCount(1, $role->getAbilities());
    }

    public function testEventIsDispatchedWhenRoleIsDuplicated()
    {
        Event::fake();

        $this->signInWithAbility('role.create');

        $originalRole = Bouncer::role()->firstOrCreate([
            'name' => 'foo',
        ]);

        $this->postJson(route('roles.duplicate', $this->role));

        $role = Role::get()->last();

        Event::assertDispatched(RoleDuplicated::class, function ($event) use ($role, $originalRole) {
            return $event->role->is($role) && $event->originalRole->is($originalRole);
        });
    }
}
