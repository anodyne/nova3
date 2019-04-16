<?php

namespace Tests\Feature\Users;

use Tests\TestCase;
use Nova\Users\Models\User;
use Nova\Users\Events;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateUserTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    public function testAuthorizedUserCanUpdateUser()
    {
        $this->signInWithAbility('user.update');

        $this->get(route('users.edit', $this->user))->assertSuccessful();
    }

    public function testUnauthorizedUserCannotUpdateUser()
    {
        $this->signIn();

        $this->get(route('users.edit', $this->user))
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->postJson(route('users.store', $this->user), [])
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testGuestCannotUpdateUser()
    {
        $this->get(route('users.edit', $this->user))
            ->assertRedirect(route('login'));

        $this->putJson(route('users.update', $this->user), [])
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testUserCanBeUpdated()
    {
        $this->signInWithAbility('user.update');

        $userData = factory(User::class)->make();

        $this->putJson(route('users.update', $this->user), $userData->toArray())
            ->assertSuccessful();

        tap($this->user->fresh(), function ($user) use ($userData) {
            $this->assertEquals($user->name, $userData->name);
            $this->assertEquals($user->email, $userData->email);
        });
    }

    public function testEventsAreDispatchedWhenUserIsUpdated()
    {
        Event::fake();

        $this->signInWithAbility('user.update');

        $this->putJson(route('users.update', $this->user), factory(User::class)->make()->toArray());

        $user = $this->user->fresh();

        Event::assertDispatched(Events\Updated::class, function ($event) use ($user) {
            return $event->user->is($user);
        });

        Event::assertDispatched(Events\AdminUpdated::class, function ($event) use ($user) {
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
