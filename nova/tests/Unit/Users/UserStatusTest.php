<?php

namespace Tests\Unit\Users;

use Tests\TestCase;
use Nova\Users\Models\User;
use Nova\Characters\Models\Character;
use Nova\Users\Models\States\Inactive;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Characters\Models\States\Statuses\Active;
use Nova\Characters\Models\States\Statuses\Inactive as InactiveCharacter;

/**
 * @group users
 */
class UserStatusTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()
            ->active()
            ->hasAttached(
                Character::factory()->count(3)->active()
            )
            ->create();
    }

    /** @test **/
    public function itDeactivatesCharactersWhenTransitioningFromActiveToInactive()
    {
        $this->user->status->transitionTo(Inactive::class);

        $this->user->refresh();

        $this->assertEquals(Inactive::class, get_class($this->user->status));

        $this->user->characters->each(function ($character) {
            $this->assertEquals(InactiveCharacter::class, get_class($character->status));
        });
    }

    /** @test **/
    public function itOnlyDeactivatesCharactersWithOneUserWhenTransitioningFromActiveToInactive()
    {
        $user = User::factory()->active()->create();
        $character = Character::factory()->active()->create();
        $character->users()->saveMany([
            $user,
            $this->user,
        ]);

        $this->user->status->transitionTo(Inactive::class);

        $this->user->refresh();
        $character->fresh();

        $this->assertEquals(Active::class, get_class($character->status));

        $this->assertEquals(InactiveCharacter::class, get_class($this->user->characters[0]->status));
        $this->assertEquals(InactiveCharacter::class, get_class($this->user->characters[1]->status));
        $this->assertEquals(InactiveCharacter::class, get_class($this->user->characters[2]->status));
    }
}
