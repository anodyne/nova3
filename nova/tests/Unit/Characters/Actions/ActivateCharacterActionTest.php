<?php

declare(strict_types=1);

namespace Tests\Unit\Characters\Actions;

use Nova\Characters\Actions\ActivateCharacter;
use Nova\Characters\Enums\CharacterType;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Statuses\Active;
use Nova\Characters\Models\States\Statuses\Inactive;
use Nova\Users\Models\User;
use Tests\TestCase;

/**
 * @group characters
 */
class ActivateCharacterActionTest extends TestCase
{
    protected $character;

    public function setUp(): void
    {
        parent::setUp();

        $this->character = Character::factory()->inactive()->create();
    }

    /** @test **/
    public function itCanActivateACharacter()
    {
        $character = ActivateCharacter::run(
            Character::factory()->inactive()->create()
        );

        $this->assertInstanceOf(Active::class, $character->status);
    }

    /** @test **/
    public function itCanActivateACharacterAsASecondaryCharacterIfTheUserAlreadyHasAnActivePrimaryCharacter()
    {
        $user = User::factory()->active()->create();

        $character1 = Character::factory()->inactive()->create();
        $character1->users()->attach($user, ['primary' => true]);
        $character1->type = CharacterType::primary;
        $character1->save();

        $character2 = Character::factory()->active()->create();
        $character2->users()->attach($user, ['primary' => true]);
        $character2->type = CharacterType::primary;
        $character2->save();

        $user->refresh();

        $this->assertCount(2, $user->characters);
        $this->assertCount(1, $user->activeCharacters);
        $this->assertCount(1, $user->primaryCharacter);
        $this->assertInstanceOf(Inactive::class, $character1->status);
        $this->assertInstanceOf(Active::class, $character2->status);
        $this->assertEquals(CharacterType::primary, $character1->type);
        $this->assertEquals(CharacterType::primary, $character2->type);

        ActivateCharacter::run($character1);

        $user->refresh();
        $character1->refresh();
        $character2->refresh();

        $this->assertCount(2, $user->characters);
        $this->assertCount(2, $user->activeCharacters);
        $this->assertCount(1, $user->primaryCharacter);
        $this->assertInstanceOf(Active::class, $character1->status);
        $this->assertInstanceOf(Active::class, $character2->status);
        $this->assertEquals(CharacterType::secondary, $character1->type);
        $this->assertEquals(CharacterType::primary, $character2->type);
    }

    /** @test **/
    public function itCanUpdateACharacterToBeASecondaryCharacterIfAnAssignedUserHasAnotherPrimaryCharacter()
    {
        $user1 = User::factory()->active()->create();
        $user2 = User::factory()->active()->create();

        $this->character->users()->attach($user1, ['primary' => true]);
        $this->character->users()->attach($user2, ['primary' => true]);

        $character1 = Character::factory()->active()->create();
        $character1->users()->attach($user1, ['primary' => true]);

        $character2 = Character::factory()->active()->create();
        $character2->users()->attach($user2, ['primary' => true]);

        $user1->refresh();
        $user2->refresh();

        $this->assertCount(2, $user1->characters()->wherePivot('primary', true)->get());
        $this->assertCount(2, $user2->characters()->wherePivot('primary', true)->get());

        $character3 = ActivateCharacter::run($this->character);

        $this->assertInstanceOf(Active::class, $character1->status);
        $this->assertTrue((bool) $character1->users()->where('users.id', $user1->id)->first()->pivot->primary);

        $this->assertInstanceOf(Active::class, $character2->status);
        $this->assertTrue((bool) $character2->users()->where('users.id', $user2->id)->first()->pivot->primary);

        $this->assertInstanceOf(Active::class, $character3->status);
        $this->assertFalse((bool) $character3->users()->where('users.id', $user1->id)->first()->pivot->primary);
        $this->assertFalse((bool) $character3->users()->where('users.id', $user2->id)->first()->pivot->primary);
    }
}
