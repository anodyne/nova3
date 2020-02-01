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

    /** @test **/
    public function authorizedUserCanDeleteUser()
    {
        $this->signInWithPermission('user.delete');

        $response = $this->delete(route('users.destroy', $this->user));
        $this->followRedirects($response)->assertOk();

        $this->assertSoftDeleted('users', $this->user->only('id'));
    }

    /** @test **/
    public function unauthorizedUserCannotDeleteUser()
    {
        $this->signIn();

        $response = $this->deleteJson(route('users.destroy', $this->user));
        $response->assertForbidden();

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'deleted_at' => null,
        ]);
    }

    /** @test **/
    public function guestCannotDeleteUser()
    {
        $response = $this->deleteJson(route('users.destroy', $this->user));
        $response->assertUnauthorized();

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'deleted_at' => null,
        ]);
    }

    /** @test **/
    public function currentUserCannotBeDeletedWhileTheyAreLoggedIn()
    {
        $this->signInWithPermission('user.delete');

        $response = $this->delete(
            route('users.destroy', $currentUser = auth()->user())
        );

        $this->assertDatabaseHas('users', $currentUser->only('id', 'nickname'));
    }

    /** @test **/
    public function eventsAreDispatchedWhenUserIsDeleted()
    {
        Event::fake();

        $this->signInWithPermission('user.delete');

        $response = $this->delete(route('users.destroy', $this->user));

        Event::assertDispatched(UserDeleted::class, function ($event) {
            return $event->user->is($this->user);
        });

        Event::assertDispatched(UserDeletedByAdmin::class, function ($event) {
            return $event->user->is($this->user);
        });
    }
}
