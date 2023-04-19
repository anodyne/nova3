<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Nova\Users\Events\UserUpdated;
use Nova\Users\Events\UserUpdatedByAdmin;
use Nova\Users\Models\User;
use Nova\Users\Requests\UpdateUserRequest;
use Tests\TestCase;

/**
 * @group users
 */
class UpdateUserTest extends TestCase
{
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->active()->create();
    }

    /** @test **/
    public function authorizedUserCanViewTheEditUserPage()
    {
        $this->signInWithPermission('user.update');

        $response = $this->get(route('users.edit', $this->user));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserCanUpdateUser()
    {
        $this->signInWithPermission('user.update');

        $data = User::factory()->make([
            'email' => $this->user->email,
        ]);

        $this->followingRedirects();

        $response = $this->put(
            route('users.update', $this->user),
            array_merge($data->toArray(), ['status' => $this->user->status])
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
            [
                'name' => 'Jack Sparrow',
                'email' => $this->user->email,
                'pronouns' => ['value' => $this->user->pronouns->value],
            ]
        );

        Event::assertDispatched(UserUpdated::class);
        Event::assertDispatched(UserUpdatedByAdmin::class);
    }

    /** @test **/
    public function unauthorizedUserCannotViewTheEditUserPage()
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
            User::factory()->make()->toArray()
        );
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewTheEditUserPage()
    {
        $response = $this->getJson(route('users.edit', $this->user));
        $response->assertUnauthorized();
    }

    /** @test **/
    public function unauthenticatedUserCannotUpdateUser()
    {
        $response = $this->putJson(
            route('users.update', $this->user),
            User::factory()->make()->toArray()
        );
        $response->assertUnauthorized();
    }
}
