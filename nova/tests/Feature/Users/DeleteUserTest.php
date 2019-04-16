<?php

namespace Tests\Feature\Users;

use Tests\TestCase;
use Nova\Users\Events;
use Nova\Users\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;
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

    public function testAuthorizedUserCanDeleteUser()
    {
        $this->signInWithAbility('user.delete');

        $this->deleteJson(route('users.destroy', $this->user))
            ->assertSuccessful();
    }

    public function testUnauthorizedUserCannotDeleteUser()
    {
        $this->signIn();

        $this->deleteJson(route('users.destroy', $this->user))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testGuestCannotDeleteUser()
    {
        $this->deleteJson(route('users.destroy', $this->user))
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testUserCanBeDeleted()
    {
        $this->signInWithAbility('user.delete');

        $this->deleteJson(route('users.destroy', $this->user))
            ->assertSuccessful();

        $this->assertSoftDeleted('users', [
            'id' => $this->user->id,
        ]);
    }

    public function testCurrentUserCannotBeDeletedWhileTheyAreLoggedIn()
    {
        $this->signInWithAbility('user.delete');

        $currentUser = auth()->user();

        $this->deleteJson(route('users.destroy', $currentUser));

        $this->assertDatabaseHas('users', [
            'id' => $currentUser->id,
            'email' => $currentUser->email,
        ]);
    }

    public function testEventsAreDispatchedWhenUserIsDeleted()
    {
        Event::fake();

        $this->signInWithAbility('user.delete');

        $this->deleteJson(route('users.destroy', $this->user));

        Event::assertDispatched(Events\Deleted::class, function ($event) {
            return $event->user->is($this->user);
        });

        Event::assertDispatched(Events\AdminDeleted::class, function ($event) {
            return $event->user->is($this->user);
        });
    }

    public function testAllUserDataIsRemovedWhenUserIsDeleted()
    {
        $this->markTestIncomplete();
    }
}
