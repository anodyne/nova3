<?php

namespace Tests\Feature\Users;

use Tests\TestCase;
use Nova\Users\User;
use Nova\Users\Events;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthorizedUserCanCreateUser()
    {
        $this->signInWithAbility('user.create');

        $this->get(route('users.create'))->assertSuccessful();
    }

    public function testUnauthorizedUserCannotCreateUser()
    {
        $this->signIn();

        $this->get(route('users.create'))
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->postJson(route('users.store'), [])
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testGuestCannotCreateUser()
    {
        $this->get(route('users.create'))
            ->assertRedirect(route('login'));

        $this->postJson(route('users.store'), [])
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testUserCanBeCreated()
    {
        $this->signInWithAbility('user.create');

        $userData = factory(User::class)->make();

        $this->postJson(route('users.store'), $userData->toArray())
            ->assertSuccessful();

        $this->assertDatabaseHas('users', [
            'name' => $userData->name,
            'email' => $userData->email,
        ]);
    }

    public function testEventIsDispatchedWhenUserIsCreated()
    {
        Event::fake();

        $this->signInWithAbility('user.create');

        $this->postJson(route('users.store'), factory(User::class)->make()->toArray());

        $user = User::get()->last();

        Event::assertDispatched(Events\Created::class, function ($event) use ($user) {
            return $event->user->is($user);
        });
    }

    public function testNameIsRequiredToCreateUser()
    {
        $this->signInWithAbility('user.create');

        $this->postJson(route('users.store'), ['email' => 'john@example.com'])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testEmailIsRequiredToCreateUser()
    {
        $this->signInWithAbility('user.create');

        $this->postJson(route('users.store'), ['name' => 'foo'])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
