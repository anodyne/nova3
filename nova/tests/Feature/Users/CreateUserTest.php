<?php

namespace Tests\Feature\Users;

use Tests\TestCase;
use Nova\Users\Models\User;
use Nova\Users\Events\UserCreated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Event;
use Nova\Users\Events\UserCreatedByAdmin;
use Nova\Users\Http\Requests\CreateUserRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Mail::fake();
    }

    /** @test **/
    public function authorizedUserCanViewTheCreateUserPage()
    {
        $this->signInWithPermission('user.create');

        $response = $this->get(route('users.create'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserCanCreateUser()
    {
        $this->signInWithPermission('user.create');

        $data = make(User::class);

        $this->followingRedirects();

        $response = $this->post(route('users.store'), $data->toArray());
        $response->assertSuccessful();

        $this->assertDatabaseHas('users', $data->only('name', 'email'));

        $this->assertRouteUsesFormRequest(
            'users.store',
            CreateUserRequest::class
        );
    }

    /** @test **/
    public function eventsAreDispatchedWhenUserIsCreated()
    {
        Event::fake();

        $this->signInWithPermission('user.create');

        $this->post(
            route('users.store'),
            make(User::class)->toArray()
        );

        Event::assertDispatched(UserCreated::class);
        Event::assertDispatched(UserCreatedByAdmin::class);
    }

    /** @test **/
    public function unauthorizedUserCannotViewCreateUserPage()
    {
        $this->signIn();

        $response = $this->get(route('users.create'));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthorizedUserCannotCreateUser()
    {
        $this->signIn();

        $response = $this->post(
            route('users.store'),
            make(User::class)->toArray()
        );
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewCreateUserPage()
    {
        $response = $this->getJson(route('users.create'));
        $response->assertUnauthorized();
    }

    /** @test **/
    public function unauthenticatedUserCannotCreateUser()
    {
        $response = $this->postJson(
            route('users.store'),
            make(User::class)->toArray()
        );
        $response->assertUnauthorized();
    }
}
