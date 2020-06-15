<?php

namespace Tests\Feature\Users;

use Tests\TestCase;
use Nova\Users\Models\User;
use Nova\Users\Events\UserUpdated;
use Illuminate\Support\Facades\Event;
use Nova\Users\Events\UserUpdatedByAdmin;
use Nova\Users\Http\Requests\UpdateUserRequest;
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

    /** @test **/
    public function authorizedUserCanViewEditUserPage()
    {
        $this->signInWithPermission('user.update');

        $response = $this->get(route('users.edit', $this->user));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserCanUpdateUser()
    {
        $this->signInWithPermission('user.update');

        $data = factory(User::class)->make();

        $this->followingRedirects();

        $response = $this->put(
            route('users.update', $this->user),
            $data->toArray()
        );
        $response->assertSuccessful();

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'name' => $data->name,
            'email' => $data->email,
        ]);

        $this->assertRouteUsesFormRequest(
            'users.update',
            UpdateUserRequest::class
        );
    }

    /** @test **/
    public function eventsAreDispatchedWhenUserIsUpdated()
    {
        Event::fake();

        $this->signInWithPermission('user.update');

        $this->put(
            route('users.update', $this->user),
            factory(User::class)->make()->toArray()
        );

        Event::assertDispatched(UserUpdated::class);
        Event::assertDispatched(UserUpdatedByAdmin::class);
    }

    /** @test **/
    public function unauthorizedUserCannotViewEditUserPage()
    {
        $this->signIn();

        $response = $this->get(route('users.edit', $this->user));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthorizedUserCannotUpdateUser()
    {
        $this->signIn();

        $this->followingRedirects();

        $response = $this->put(
            route('users.update', $this->user),
            factory(User::class)->make()->toArray()
        );
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewEditUserPage()
    {
        $response = $this->getJson(route('users.edit', $this->user));
        $response->assertUnauthorized();
    }

    /** @test **/
    public function unauthenticatedUserCannotUpdateUser()
    {
        $response = $this->putJson(
            route('users.update', $this->user),
            factory(User::class)->make()->toArray()
        );
        $response->assertUnauthorized();
    }
}
