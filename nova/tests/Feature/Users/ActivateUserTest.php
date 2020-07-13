<?php

namespace Tests\Feature\Users;

use Tests\TestCase;
use Nova\Users\Models\User;
use Nova\Characters\Models\Character;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Users\Models\States\Active as ActiveUser;
use Nova\Characters\Models\States\Statuses\Active as ActiveCharacter;

/**
 * @group users
 * @group characters
 */
class ActivateUserTest extends TestCase
{
    use RefreshDatabase;

    protected $character;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = create(User::class, [], ['status:inactive']);

        $this->character = create(Character::class, [], ['status:inactive']);
        $this->character->users()->attach($this->user, ['primary' => true]);
    }

    /** @test **/
    public function authorizedUserCanActivateUser()
    {
        $this->signInWithPermission('user.update');

        $this->followingRedirects();

        $response = $this->post(route('users.activate', $this->user));
        $response->assertSuccessful();

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'status' => ActiveUser::class,
        ]);
    }

    /** @test **/
    public function userCanBeActivatedWithPreviousPrimaryCharacter()
    {
        $this->withoutExceptionHandling();

        $this->signInWithPermission('user.update');

        $this->followingRedirects();

        $response = $this->post(route('users.activate', $this->user), [
            'activate_primary_character' => '1',
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'status' => ActiveUser::class,
        ]);

        $this->assertDatabaseHas('characters', [
            'id' => $this->character->id,
            'status' => ActiveCharacter::class,
        ]);
    }

    /** @test **/
    public function unauthorizedUserCannotActivateUser()
    {
        $this->signIn();

        $this->followingRedirects();

        $response = $this->post(route('users.activate', $this->user));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotActivateUser()
    {
        $response = $this->postJson(route('users.activate', $this->user));
        $response->assertUnauthorized();
    }
}
