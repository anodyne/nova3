<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Statuses\Active as ActiveCharacter;
use Nova\Users\Models\States\Active as ActiveUser;
use Nova\Users\Models\User;
use Tests\TestCase;

/**
 * @group users
 * @group characters
 */
class ActivateUserTest extends TestCase
{
    protected $character;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->inactive()->create();

        $this->character = Character::factory()->inactive()->create();
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
            'status' => ActiveUser::$name,
        ]);
    }

    /** @test **/
    public function userCanBeActivatedWithPreviousPrimaryCharacter()
    {
        $this->signInWithPermission('user.update');

        $this->followingRedirects();

        $response = $this->post(route('users.activate', $this->user), [
            'activate_primary_character' => '1',
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'status' => ActiveUser::$name,
        ]);

        $this->assertDatabaseHas('characters', [
            'id' => $this->character->id,
            'status' => ActiveCharacter::$name,
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
