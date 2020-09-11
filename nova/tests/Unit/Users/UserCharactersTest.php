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

        $this->user = User::factory()->active()->create();

        $this->activePrimaryCharacter = Character::factory()->active()->create();
        $this->activePrimaryCharacter->users()->attach($this->user, ['primary' => true]);

        $this->secondaryCharacter = Character::factory()->active()->create();
        $this->secondaryCharacter->users()->attach($this->user);

        $this->inactiveCharacter = Character::factory()->inactive()->create();
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
