<?php

namespace Tests\Unit\Users;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Characters\Models\Character;
use Nova\Users\Models\User;
use Tests\TestCase;

/**
 * @group users
 */
class UserCharactersTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected $activePrimaryCharacter;

    protected $secondaryCharacter;

    protected $inactiveCharacter;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = create(User::class, [], ['status:active']);

        $this->activePrimaryCharacter = create(Character::class, [], ['status:active']);
        $this->activePrimaryCharacter->users()->attach($this->user, ['primary' => true]);

        $this->secondaryCharacter = create(Character::class, [], ['status:active']);
        $this->secondaryCharacter->users()->attach($this->user);

        $this->inactiveCharacter = create(Character::class, [], ['status:inactive']);
        $this->inactiveCharacter->users()->attach($this->user);

        $this->user->refresh();
    }

    /** @test **/
    public function itCanAccessAllCharactersAssignedToTheUser()
    {
        $this->assertCount(3, $this->user->characters);
    }

    /** @test **/
    public function itCanAccessOnlyActiveCharactersAssignedToTheUser()
    {
        $this->assertCount(2, $this->user->activeCharacters);
    }

    /** @test **/
    public function itCanAccessOnlyActivePrimaryCharacterAssignedToTheUser()
    {
        $this->assertCount(1, $this->user->primaryCharacter);
    }
}
