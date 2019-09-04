<?php

namespace Tests\Feature\Users;

use Tests\TestCase;
use Nova\Users\Models\User;
use Illuminate\Http\Response;
use Nova\Users\Events\UserUpdated;
use Illuminate\Support\Facades\Event;
use Nova\Users\Events\UserUpdatedByAdmin;
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

    /**
     * @test
     */
    public function authorizedUserCanUpdateUser()
    {
        $this->signInWithAbility('user.update');

        $response = $this->get(route('users.edit', $this->user));

        $response->assertSuccessful();
    }

    /**
     * @test
     */
    public function unauthorizedUserCannotUpdateUser()
    {
        $this->signIn();

        $response = $this->get(route('users.edit', $this->user));

        $response->assertForbidden();

        $response = $this->postJson(route('users.store', $this->user), []);

        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function GuestCannotUpdateUser()
    {
        $this->get(route('users.edit', $this->user))
            ->assertRedirect(route('login'));

        $this->putJson(route('users.update', $this->user), [])
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @test
     */
    public function UserCanBeUpdated()
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

    /**
     * @test
     */
    public function EventsAreDispatchedWhenUserIsUpdated()
    {
        Event::fake();

        $this->signInWithAbility('user.update');

        $this->putJson(route('users.update', $this->user), factory(User::class)->make()->toArray());

        $user = $this->user->fresh();

        Event::assertDispatched(UserUpdated::class, function ($event) use ($user) {
            return $event->user->is($user);
        });

        Event::assertDispatched(UserUpdatedByAdmin::class, function ($event) use ($user) {
            return $event->user->is($user);
        });
    }

    /**
     * @test
     */
    public function NameIsRequiredToCreateUser()
    {
        $this->signInWithAbility('user.create');

        $this->postJson(route('users.store'), ['email' => 'john@example.com'])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     */
    public function EmailIsRequiredToCreateUser()
    {
        $this->signInWithAbility('user.create');

        $this->postJson(route('users.store'), ['name' => 'foo'])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
