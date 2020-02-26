<?php

namespace Tests\Feature\Users;

use Tests\TestCase;
use Nova\Users\Models\User;
use Nova\Users\Events\UserUpdated;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Nova\Users\Events\UserUpdatedByAdmin;
use Nova\Users\Http\Requests\ValidateUpdateUser;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @see \Nova\Users\Http\Controllers\UserController
 */
class UpdateUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var  User
     */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();

        Storage::fake('media');
    }

    /** @test **/
    public function authorizedUserCanSeeUpdateUserPage()
    {
        $this->signInWithPermission('user.update');

        $response = $this->get(route('users.edit', $this->user));
        $response->assertOk();
    }

    /** @test **/
    public function authorizedUserCanUpdateUser()
    {
        $this->signInWithPermission('user.update');

        $data = factory(User::class)->make();

        $response = $this->put(
            route('users.update', $this->user),
            array_merge($data->toArray(), ['roles' => []])
        );
        $this->followRedirects($response)->assertOk();

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'name' => $data->name,
            'email' => $data->email,
        ]);
    }

    /** @test **/
    public function unauthorizedUserCannotUpdateUser()
    {
        $this->signIn();

        $response = $this->get(route('users.edit', $this->user));
        $response->assertForbidden();

        $response = $this->putJson(route('users.update', $this->user), []);
        $response->assertForbidden();
    }

    /** @test **/
    public function guestCannotUpdateUser()
    {
        $response = $this->getJson(route('users.edit', $this->user));
        $response->assertUnauthorized();

        $response = $this->putJson(route('users.update', $this->user), []);
        $response->assertUnauthorized();
    }

    /** @test **/
    public function eventsAreDispatchedWhenUserIsUpdated()
    {
        Event::fake();

        $this->signInWithPermission('user.update');

        $this->put(
            route('users.update', $this->user),
            array_merge(
                factory(User::class)->make()->toArray(),
                ['roles' => []]
            )
        );

        $user = $this->user->refresh();

        Event::assertDispatched(UserUpdated::class, function ($event) use ($user) {
            return $event->user->is($user);
        });

        Event::assertDispatched(UserUpdatedByAdmin::class, function ($event) use ($user) {
            return $event->user->is($user);
        });
    }

    /** @test **/
    public function nameIsRequiredToUpdateUser()
    {
        $this->signInWithPermission('user.update');

        $response = $this->putJson(route('users.update', $this->user), [
            'email' => 'john@example.com',
            'roles' => [],
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('name');
    }

    /** @test **/
    public function emailIsRequiredToUpdateUser()
    {
        $this->signInWithPermission('user.update');

        $response = $this->putJson(route('users.update', $this->user), [
            'name' => 'foo',
            'roles' => [],
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
    }

    /** @test **/
    public function genderIsRequiredToUpdateUser()
    {
        $this->signInWithPermission('user.update');

        $response = $this->putJson(route('users.update', $this->user), [
            'name' => 'foo',
            'email' => 'john@example.com',
            'roles' => [],
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('gender');
    }

    /** @test **/
    public function updatingUserInDatabaseUsesFormRequest()
    {
        $this->assertRouteUsesFormRequest(
            'users.update',
            ValidateUpdateUser::class
        );
    }
}
