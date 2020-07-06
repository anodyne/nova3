<?php

namespace Tests\Feature\Users;

use Tests\TestCase;
use Nova\Users\Models\User;
use Nova\Characters\Models\Character;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Users\Models\States\Inactive as InactiveUser;
use Nova\Characters\Models\States\Statuses\Inactive as InactiveCharacter;

/**
 * @group users
 * @group characters
 */
class DeactivateUserTest extends TestCase
{
    use RefreshDatabase;

    protected $character;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = create(User::class, [], ['status:active']);

        $this->character = create(Character::class, [], ['status:active']);
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
            'status' => InactiveUser::class,
        ]);

        $this->assertDatabaseHas('characters', [
            'id' => $this->character->id,
            'status' => InactiveCharacter::class,
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
