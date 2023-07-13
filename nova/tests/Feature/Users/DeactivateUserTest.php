<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Status\Inactive as InactiveCharacter;
use Nova\Users\Models\States\Inactive as InactiveUser;
use Nova\Users\Models\User;
use Tests\TestCase;

/**
 * @group users
 * @group characters
 */
class DeactivateUserTest extends TestCase
{
    protected $character;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->active()->create();

        $this->character = Character::factory()->active()->create();
        $this->character->users()->attach($this->user);
    }

    /** @test **/
    public function authorizedUserCanDeactivateUser()
    {
        $this->signInWithPermission('user.update');

        $this->followingRedirects();

        $response = $this->post(route('users.deactivate', $this->user));
        $response->assertSuccessful();

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'status' => InactiveUser::$name,
        ]);

        $this->assertDatabaseHas('characters', [
            'id' => $this->character->id,
            'status' => InactiveCharacter::$name,
        ]);
    }

    /** @test **/
    public function unauthorizedUserCannotDeactivateUser()
    {
        $this->signIn();

        $this->followingRedirects();

        $response = $this->post(route('users.deactivate', $this->user));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotDeactivateUser()
    {
        $response = $this->postJson(route('users.deactivate', $this->user));
        $response->assertUnauthorized();
    }
}
