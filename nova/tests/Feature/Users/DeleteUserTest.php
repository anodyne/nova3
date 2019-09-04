<?php

namespace Tests\Feature\Users;

use Tests\TestCase;
use Nova\Users\Models\User;
use Nova\Users\Events\UserDeleted;
use Illuminate\Support\Facades\Event;
use Nova\Users\Events\UserDeletedByAdmin;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteUserTest extends TestCase
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
    public function authorizedUserCanDeleteUser()
    {
        $this->signInWithAbility('user.delete');

        $response = $this->deleteJson(route('users.destroy', $this->user));

        $response->assertSuccessful();
    }

    /**
     * @test
     */
    public function unauthorizedUserCannotDeleteUser()
    {
        $this->signIn();

        $response = $this->deleteJson(route('users.destroy', $this->user));

        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function guestCannotDeleteUser()
    {
        $response = $this->deleteJson(route('users.destroy', $this->user));

        $response->assertUnauthorized();
    }

    /**
     * @test
     */
    public function userCanBeDeleted()
    {
        $this->signInWithAbility('user.delete');

        $response = $this->deleteJson(route('users.destroy', $this->user));

        $response->assertSuccessful();

        $this->assertSoftDeleted('users', $this->user->only('id'));
    }

    /**
     * @test
     */
    public function currentUserCannotBeDeletedWhileTheyAreLoggedIn()
    {
        $this->signInWithAbility('user.delete');

        $response = $this->deleteJson(
            route('users.destroy', $currentUser = auth()->user())
        );

        $this->assertDatabaseHas('users', $currentUser->only('id', 'name'));
    }

    /**
     * @test
     */
    public function eventsAreDispatchedWhenUserIsDeleted()
    {
        Event::fake();

        $this->signInWithAbility('user.delete');

        $response = $this->deleteJson(route('users.destroy', $this->user));

        Event::assertDispatched(UserDeleted::class, function ($event) {
            return $event->user->is($this->user);
        });

        Event::assertDispatched(UserDeletedByAdmin::class, function ($event) {
            return $event->user->is($this->user);
        });
    }

    /**
     * @test
     */
    public function allUserDataIsRemovedWhenUserIsDeleted()
    {
        $this->markTestIncomplete();
    }
}
