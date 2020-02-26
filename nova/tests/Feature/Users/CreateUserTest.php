<?php

namespace Tests\Feature\Users;

use Tests\TestCase;
use Nova\Roles\Models\Role;
use Nova\Users\Models\User;
use Nova\Users\Events\UserCreated;
use Illuminate\Support\Facades\Event;
use Nova\Users\Events\UserCreatedByAdmin;
use Illuminate\Support\Facades\Notification;
use Nova\Users\Notifications\AccountCreated;
use Nova\Users\Http\Requests\ValidateStoreUser;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @see \Nova\Users\Http\Controllers\UserController
 */
class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function authorizedUserCanSeeCreateUserPage()
    {
        $this->signInWithPermission('user.create');

        $response = $this->get(route('users.create'));
        $response->assertOk();
    }

    /** @test **/
    public function authorizedUserCanCreateUser()
    {
        $this->signInWithPermission('user.create');

        $data = factory(User::class)->make();

        $role = factory(Role::class)->create();

        $response = $this->post(
            route('users.store'),
            array_merge($data->toArray(), ['roles' => [$role->name]])
        );
        $this->followRedirects($response)->assertOk();

        $user = User::get()->last();

        $this->assertDatabaseHas('users', $data->only('name', 'email'));

        $this->assertDatabaseHas('role_user', [
            'role_id' => $role->id,
            'user_id' => $user->id,
        ]);
    }

    /** @test **/
    public function unauthorizedUserCannotCreateUser()
    {
        $this->signIn();

        $response = $this->getJson(route('users.create'));
        $response->assertForbidden();

        $response = $this->postJson(route('users.store'), []);
        $response->assertForbidden();
    }

    /** @test **/
    public function guestCannotCreateUser()
    {
        $response = $this->getJson(route('users.create'));
        $response->assertUnauthorized();

        $response = $this->postJson(route('users.store'), []);
        $response->assertUnauthorized();
    }

    /** @test **/
    public function eventsAreDispatchedWhenUserIsCreated()
    {
        Event::fake();

        $this->signInWithPermission('user.create');

        $response = $this->post(
            route('users.store'),
            array_merge(
                factory(User::class)->make()->toArray(),
                ['roles' => []]
            )
        );

        $user = User::get()->last();

        Event::assertDispatched(UserCreatedByAdmin::class, function ($event) use ($user) {
            return $event->user->is($user);
        });

        Event::assertDispatched(UserCreated::class, function ($event) use ($user) {
            return $event->user->is($user);
        });
    }

    /** @test **/
    public function nameIsRequiredToCreateUser()
    {
        $this->signInWithPermission('user.create');

        $response = $this->postJson(route('users.store'), [
            'email' => 'john@example.com',
            'roles' => [],
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('name');
    }

    /** @test **/
    public function emailIsRequiredToCreateUser()
    {
        $this->signInWithPermission('user.create');

        $response = $this->postJson(route('users.store'), [
            'name' => 'foo',
            'roles' => [],
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
    }

    /** @test **/
    public function genderIsRequiredToCreateUser()
    {
        $this->signInWithPermission('user.create');

        $response = $this->postJson(route('users.store'), [
            'name' => 'foo',
            'email' => 'john@example.com',
            'roles' => [],
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('gender');
    }

    /** @test **/
    public function passwordIsGeneratedAfterCreation()
    {
        $this->signInWithPermission('user.create');

        $response = $this->postJson(route('users.store'), [
            'name' => 'John Q. Public',
            'email' => 'john@example.com',
            'roles' => [],
        ]);

        $user = User::get()->last();

        $this->assertNotNull($user->password);
    }

    /** @test **/
    public function userIsNotifiedWithPasswordAfterCreation()
    {
        Notification::fake();

        $this->signInWithPermission('user.create');

        $response = $this->postJson(route('users.store'), [
            'name' => 'John Q. Public',
            'email' => 'john@example.com',
            'gender' => 'neutral',
            'roles' => [],
        ]);

        $user = User::get()->last();

        Notification::assertSentTo([$user], AccountCreated::class);
    }

    /** @test **/
    public function storingUserInDatabaseUsesFormRequest()
    {
        $this->assertRouteUsesFormRequest(
            'users.store',
            ValidateStoreUser::class
        );
    }
}
