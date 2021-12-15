<?php

declare(strict_types=1);

namespace Tests\Unit\Characters\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Characters\Actions\ActivateCharacter;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Statuses\Active;
use Nova\Characters\Models\States\Statuses\Inactive;
use Nova\Characters\Models\States\Types\Primary;
use Nova\Characters\Models\States\Types\Secondary;
use Nova\Users\Models\User;
use Tests\TestCase;

/**
 * @group characters
 */
class ActivateCharacterActionTest extends TestCase
{
    use RefreshDatabase;

    protected $character;

    public function setUp(): void
    {
        parent::setUp();

        $this->character = Character::factory()->inactive()->create();
    }

    /** @test **/
    public function itActivatesACharacter()
    {
        $jackSparrow = Character::factory()->inactive()->create();

        $jackSparrow = ActivateCharacter::run($jackSparrow);

        $this->assertInstanceOf(Active::class, $jackSparrow->status);
    }

    /** @test **/
    public function itActivatesTheCharacterAsASecondaryCharacterIfTheUserAlreadyHasAnActivePrimaryCharacter()
    {
        $johnny = User::factory()->active()->create();

        $bobSparrow = Character::factory()->inactive()->create();
        $bobSparrow->users()->attach($johnny, ['primary' => true]);
        $bobSparrow->type = Primary::class;
        $bobSparrow->save();

        $jackSparrow = Character::factory()->active()->create();
        $jackSparrow->users()->attach($johnny, ['primary' => true]);
        $jackSparrow->type = Primary::class;
        $jackSparrow->save();

        $johnny->refresh();

        $this->assertCount(2, $johnny->characters);
        $this->assertCount(1, $johnny->activeCharacters);
        $this->assertInstanceOf(Inactive::class, $bobSparrow->status);

        ActivateCharacter::run($bobSparrow);

        $johnny->refresh();
        $jackSparrow->refresh();
        $bobSparrow->refresh();

        $this->assertCount(2, $johnny->activeCharacters);
        $this->assertCount(1, $johnny->primaryCharacter);
        $this->assertInstanceOf(Primary::class, $jackSparrow->type);
        $this->assertInstanceOf(Secondary::class, $bobSparrow->type);
    }

    /** @test **/
    public function itUpdatesTheCharacterToBeASecondaryCharacterIfAnAssignedUserHasAnotherPrimaryCharacter()
    {
        $adam = User::factory()->active()->create();
        $ben = User::factory()->active()->create();

        $this->character->users()->attach($adam, ['primary' => true]);
        $this->character->users()->attach($ben, ['primary' => true]);

        $jackSparrow = Character::factory()->active()->create();
        $jackSparrow->users()->attach($adam, ['primary' => true]);

        $willTurner = Character::factory()->active()->create();
        $willTurner->users()->attach($ben, ['primary' => true]);

        $adam->refresh();
        $ben->refresh();

        $this->assertCount(2, $adam->characters()->wherePivot('primary', true)->get());
        $this->assertCount(2, $ben->characters()->wherePivot('primary', true)->get());

        $elizabethSwann = ActivateCharacter::run($this->character);

        $this->assertInstanceOf(Active::class, $elizabethSwann->status);
        $this->assertFalse((bool) $elizabethSwann->users()->where('users.id', $adam->id)->first()->pivot->primary);
        $this->assertFalse((bool) $elizabethSwann->users()->where('users.id', $ben->id)->first()->pivot->primary);

        $this->assertInstanceOf(Active::class, $jackSparrow->status);
        $this->assertTrue((bool) $jackSparrow->users()->where('users.id', $adam->id)->first()->pivot->primary);

        $this->assertInstanceOf(Active::class, $willTurner->status);
        $this->assertTrue((bool) $willTurner->users()->where('users.id', $ben->id)->first()->pivot->primary);
    }
}
