<?php

namespace Tests\Feature\Themes;

use Bouncer;
use Tests\TestCase;
use Illuminate\Http\Response;
use Nova\Authorization\Events;
use Silber\Bouncer\Database\Role;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateRoleTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthorizedUserCanCreateRole()
    {
        $this->signInWithAbility('role.create');

        $this->get(route('roles.create'))->assertSuccessful();
    }

    public function testUnauthorizedUserCannotCreateRole()
    {
        $this->signIn();

        $this->get(route('roles.create'))
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->postJson(route('roles.store'), [])
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testGuestCannotCreateRole()
    {
        $this->get(route('roles.create'))
            ->assertRedirect(route('login'));

        $this->postJson(route('roles.store'), [])
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testRoleCanBeCreated()
    {
        $this->signInWithAbility('role.create');

        $roleData = factory(Role::class)->make()->toArray();

        $postData = array_merge(
            $roleData,
            ['abilities' => ['foo', 'bar', 'baz']]
        );

        $this->postJson(route('roles.store'), $postData)
            ->assertSuccessful();

        $role = Role::get()->last();

        $this->assertDatabaseHas('roles', $roleData);

        $this->assertCount(3, $role->getAbilities());
    }

    public function testRoleCanBeCreatedWithExistingRoleData()
    {
        $this->signInWithAbility('role.create');

        $ability = Bouncer::ability()->firstOrCreate(['name' => 'foo']);

        $originalRole = factory(Role::class)->create();
        Bouncer::allow($originalRole)->to($ability);

        $originalRoleAbilities = $originalRole->fresh()->getAbilities()
            ->map(function ($ability) {
                return $ability->name;
            });

        $roleData = factory(Role::class)->make()->toArray();

        $this->postJson(route('roles.store'), array_merge(
            $roleData,
            ['abilities' => $originalRoleAbilities->all()]
        ));

        $role = Role::get()->last();

        $this->assertCount(1, $originalRole->fresh()->getAbilities());
        $this->assertCount(1, $role->getAbilities());
    }

    public function testEventIsDispatchedWhenRoleIsCreated()
    {
        Event::fake();

        $this->signInWithAbility('role.create');

        $this->postJson(route('roles.store'), factory(Role::class)->make()->toArray());

        $role = Role::get()->last();

        Event::assertDispatched(Events\RoleCreated::class, function ($event) use ($role) {
            return $event->role->is($role);
        });
    }

    public function testNameIsRequiredToCreateRole()
    {
        $this->signInWithAbility('role.create');

        $this->postJson(route('roles.store'), ['title' => 'Foo'])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testNameMustBeUnique()
    {
        $role = factory(Role::class)->create();

        $this->signInWithAbility('role.create');

        $this->postJson(route('roles.store'), ['name' => $role->name, 'title' => 'Title'])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testTitleIsRequiredToCreateRole()
    {
        $this->signInWithAbility('role.create');

        $this->postJson(route('roles.store'), ['name' => 'foo'])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
