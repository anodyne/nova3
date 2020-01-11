<?php

namespace Tests\Feature\Roles;

use Tests\TestCase;
use Nova\Roles\Models\Role;
use Illuminate\Http\Response;
use Nova\Roles\Events\RoleCreated;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateRoleTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function authorizedUserCanCreateRole()
    {
        $this->signInWithAbility('role.create');

        $this->get(route('roles.create'))->assertSuccessful();
    }

    /** @test **/
    public function unauthorizedUserCannotCreateRole()
    {
        $this->signIn();

        $this->get(route('roles.create'))
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->postJson(route('roles.store'), [])
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test **/
    public function guestCannotCreateRole()
    {
        $this->get(route('roles.create'))
            ->assertRedirect(route('login'));

        $this->postJson(route('roles.store'), [])
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test **/
    public function roleCanBeCreated()
    {
        $this->signInWithAbility('role.create');

        $roleData = factory(Role::class)->make();

        $postData = array_merge(
            $roleData->toArray(),
            [
                'abilities' => ['foo', 'bar', 'baz'],
                'users' => [],
            ]
        );

        $this->postJson(route('roles.store'), $postData)
            ->assertSuccessful();

        $role = Role::get()->last();

        $this->assertCount(3, $role->getAbilities());

        $this->assertDatabaseHas('roles', [
            'name' => $roleData->name,
            'title' => $roleData->title,
        ]);
    }

    /** @test **/
    public function eventIsDispatchedWhenRoleIsCreated()
    {
        Event::fake();

        $this->signInWithAbility('role.create');

        $data = array_merge(
            factory(Role::class)->make()->toArray(),
            [
                'abilities' => ['foo', 'bar', 'baz'],
                'users' => [],
            ]
        );

        $this->postJson(route('roles.store'), $data);

        $role = Role::get()->last();

        Event::assertDispatched(RoleCreated::class, function ($event) use ($role) {
            return $event->role->is($role);
        });
    }

    /** @test **/
    public function nameIsRequiredToCreateRole()
    {
        $this->signInWithAbility('role.create');

        $this->postJson(route('roles.store'), ['title' => 'Foo'])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test **/
    public function nameMustBeUnique()
    {
        $role = factory(Role::class)->create();

        $this->signInWithAbility('role.create');

        $this->postJson(route('roles.store'), ['name' => $role->name, 'title' => 'Title'])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test **/
    public function titleIsRequiredToCreateRole()
    {
        $this->signInWithAbility('role.create');

        $this->postJson(route('roles.store'), ['name' => 'foo'])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test **/
    public function roleCanBeGivenToUser()
    {
        $this->signInWithAbility('role.create');

        $user = $this->createUser();

        $role = factory(Role::class)->make();

        $data = array_merge(
            $role->toArray(),
            [
                'abilities' => [],
                'users' => [$user->id],
            ]
        );

        $response = $this->postJson(route('roles.store'), $data);

        $response->assertSuccessful();

        $this->assertTrue($user->isA($role->name));
    }
}
