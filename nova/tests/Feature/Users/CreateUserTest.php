<?php

namespace Tests\Feature\Users;

use Tests\TestCase;
use Nova\Users\Events;
use Nova\Users\Models\User;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Nova\Users\Notifications\AccountCreated;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function authorizedUserCanCreateUser()
    {
        $this->signInWithAbility('user.create');

        $response = $this->get(route('users.create'));

        $response->assertSuccessful();
    }

    /**
     * @test
     */
    public function unauthorizedUserCannotCreateUser()
    {
        $this->signIn();

        $response = $this->get(route('users.create'));

        $response->assertForbidden();

        $response = $this->postJson(route('users.store'), []);

        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function guestCannotCreateUser()
    {
        $response = $this->get(route('users.create'));

        $response->assertRedirect(route('login'));

        $response = $this->postJson(route('users.store'), []);

        $response->assertUnauthorized();
    }

    /**
     * @test
     */
    public function userCanBeCreated()
    {
        $this->signInWithAbility('user.create');

        $data = factory(User::class)->make();

        $response = $this->postJson(route('users.store'), $data->toArray());

        $response->assertSuccessful();

        $this->assertDatabaseHas('users', $data->only('name', 'email'));
    }

    /**
     * @test
     */
    public function eventsAreDispatchedWhenUserIsCreated()
    {
        Event::fake();

        $this->signInWithAbility('user.create');

        $response = $this->postJson(
            route('users.store'),
            factory(User::class)->make()->toArray()
        );

        $user = User::get()->last();

        Event::assertDispatched(Events\AdminCreated::class, function ($event) use ($user) {
            return $event->user->is($user);
        });

        Event::assertDispatched(Events\Created::class, function ($event) use ($user) {
            return $event->user->is($user);
        });
    }

    /**
     * @test
     */
    public function nameIsRequiredToCreateUser()
    {
        $this->signInWithAbility('user.create');

        $response = $this->postJson(route('users.store'), [
            'email' => 'john@example.com',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('name');
    }

    /**
     * @test
     */
    public function emailIsRequiredToCreateUser()
    {
        $this->signInWithAbility('user.create');

        $response = $this->postJson(route('users.store'), [
            'name' => 'foo',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
    }

    /**
     * @test
     */
    public function passwordIsGeneratedAfterCreation()
    {
        $this->signInWithAbility('user.create');

        $response = $this->postJson(route('users.store'), [
            'name' => 'John Q. Public',
            'email' => 'john@example.com',
        ]);

        $user = User::get()->last();

        $this->assertNotNull($user->password);
    }

    /**
     * @test
     */
    public function userIsNotifiedWithPasswordAfterCreation()
    {
        Notification::fake();

        $this->signInWithAbility('user.create');

        $response = $this->postJson(route('users.store'), [
            'name' => 'John Q. Public',
            'email' => 'john@example.com',
        ]);

        $user = User::get()->last();

        Notification::assertSentTo([$user], AccountCreated::class);
    }
}
