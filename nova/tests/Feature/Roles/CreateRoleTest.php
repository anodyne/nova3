<?php

namespace Tests\Feature\Roles;

use Tests\TestCase;
use Nova\Roles\Events;
use Nova\Roles\Models\Role;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateRoleTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthorizedUserCanCreateRole()
    {
        $this->withoutExceptionHandling();
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

        $roleData = factory(Role::class)->make();

        $postData = array_merge(
            $roleData->toArray(),
            ['abilities' => ['foo', 'bar', 'baz']]
        );

        $this->postJson(route('roles.store'), $postData)
            ->assertSuccessful();

        $role = Role::get()->last();

        $this->assertDatabaseHas('roles', [
            'name' => $roleData->name,
            'title' => $roleData->title,
        ]);

        $this->assertCount(3, $role->getAbilities());
    }

    public function testEventIsDispatchedWhenRoleIsCreated()
    {
        Event::fake();

        $this->signInWithAbility('role.create');

        $data = array_merge(
            factory(Role::class)->make()->toArray(),
            ['abilities' => ['foo', 'bar', 'baz']]
        );

        $this->postJson(route('roles.store'), $data);

        $role = Role::get()->last();

        Event::assertDispatched(Events\Created::class, function ($event) use ($role) {
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
