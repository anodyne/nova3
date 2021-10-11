<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Nova\Characters\Models\Character;
use Nova\Users\Events\UserDeleted;
use Nova\Users\Events\UserDeletedByAdmin;
use Nova\Users\Models\User;
use Tests\TestCase;

/**
 * @group users
 */
class DeleteUserTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->active()->create();
    }

    /** @test **/
    public function authorizedUserCanDeleteUser()
    {
        $this->signInWithPermission('user.delete');

        $this->followingRedirects();

        $response = $this->delete(route('users.destroy', $this->user));
        $response->assertSuccessful();

        $this->assertSoftDeleted('users', $this->user->only('id'));
    }

    /** @test **/
    public function eventsAreDispatchedWhenUserIsDeleted()
    {
        Event::fake();

        $this->signInWithPermission('user.delete');

        $this->delete(route('users.destroy', $this->user));

        Event::assertDispatched(UserDeleted::class);
        Event::assertDispatched(UserDeletedByAdmin::class);
    }

    /** @test **/
    public function charactersAssignedToTheUserAreDeletedWhenTheUserIsDeleted()
    {
        $character = Character::factory()->active()->create();
        $this->user->characters()->attach($character);

        $this->signInWithPermission('user.delete');

        $response = $this->delete(route('users.destroy', $this->user));

        $this->assertSoftDeleted('users', $this->user->only('id'));

        $this->assertSoftDeleted('characters', $character->only('id'));
    }

    /** @test **/
    public function currentUserCannotDeleteTheirAccountFromUserManagement()
    {
        $this->signInWithPermission('user.delete');

        $response = $this->delete(
            route('users.destroy', $user = auth()->user())
        );
        $response->assertForbidden();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'deleted_at' => null,
        ]);
    }

    /** @test **/
    public function unauthorizedUserCannotDeleteUser()
    {
        $this->signIn();

        $response = $this->delete(route('users.destroy', $this->user));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotDeleteUser()
    {
        $response = $this->deleteJson(route('users.destroy', $this->user));
        $response->assertUnauthorized();
    }
}
