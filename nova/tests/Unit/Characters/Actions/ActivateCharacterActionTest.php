<?php

namespace Tests\Unit\Characters\Actions;

use Tests\TestCase;
use Nova\Users\Models\User;
use Nova\Characters\Models\Character;
use Nova\Characters\Actions\ActivateCharacter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Characters\Models\States\Statuses\Active;
use Nova\Characters\Models\States\Statuses\Inactive;
use Nova\Characters\Models\States\Types\Primary;
use Nova\Characters\Models\States\Types\Secondary;

/**
 * @group characters
 */
class ActivateCharacterActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $character;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(ActivateCharacter::class);

        $this->character = create(Character::class, [], ['status:inactive']);
    }

    /** @test **/
    public function itActivatesACharacter()
    {
        $jackSparrow = create(Character::class, [], ['status:inactive']);

        $jackSparrow = $this->action->execute($jackSparrow);

        $this->assertTrue($jackSparrow->status->equals(Active::class));
    }

    /** @test **/
    public function itActivatesTheCharacterAsASecondaryCharacterIfTheUserAlreadyHasAnActivePrimaryCharacter()
    {
        $johnny = create(User::class, [], ['status:active']);

        $bobSparrow = create(Character::class, [], ['status:inactive']);
        $bobSparrow->users()->attach($johnny, ['primary' => true]);
        $bobSparrow->type = Primary::class;
        $bobSparrow->save();

        $jackSparrow = create(Character::class, [], ['status:active']);
        $jackSparrow->users()->attach($johnny, ['primary' => true]);
        $jackSparrow->type = Primary::class;
        $jackSparrow->save();

        $johnny->refresh();

        $this->assertCount(2, $johnny->characters);
        $this->assertCount(1, $johnny->activeCharacters);
        $this->assertTrue($bobSparrow->status->equals(Inactive::class));

        $this->action->execute($bobSparrow);

        $johnny->refresh();
        $jackSparrow->refresh();
        $bobSparrow->refresh();

        $this->assertCount(2, $johnny->activeCharacters);
        $this->assertCount(1, $johnny->primaryCharacter);
        $this->assertTrue($jackSparrow->type->equals(Primary::class));
        $this->assertTrue($bobSparrow->type->equals(Secondary::class));
    }

    /** @test **/
    public function itUpdatesTheCharacterToBeASecondaryCharacterIfAnAssignedUserHasAnotherPrimaryCharacter()
    {
        $adam = create(User::class, [], ['status:active']);
        $ben = create(User::class, [], ['status:active']);

        $this->character->users()->attach($adam, ['primary' => true]);
        $this->character->users()->attach($ben, ['primary' => true]);

        $jackSparrow = create(Character::class, [], ['status:active']);
        $jackSparrow->users()->attach($adam, ['primary' => true]);

        $willTurner = create(Character::class, [], ['status:active']);
        $willTurner->users()->attach($ben, ['primary' => true]);

        $adam->refresh();
        $ben->refresh();

        $this->assertCount(2, $adam->characters()->wherePivot('primary', true)->get());
        $this->assertCount(2, $ben->characters()->wherePivot('primary', true)->get());

        $elizabethSwann = $this->action->execute($this->character);

        $this->assertTrue($elizabethSwann->status->equals(Active::class));
        $this->assertFalse((bool) $elizabethSwann->users()->where('users.id', $adam->id)->first()->pivot->primary);
        $this->assertFalse((bool) $elizabethSwann->users()->where('users.id', $ben->id)->first()->pivot->primary);

        $this->assertTrue($jackSparrow->status->equals(Active::class));
        $this->assertTrue((bool) $jackSparrow->users()->where('users.id', $adam->id)->first()->pivot->primary);

        $this->assertTrue($willTurner->status->equals(Active::class));
        $this->assertTrue((bool) $willTurner->users()->where('users.id', $ben->id)->first()->pivot->primary);
    }
}
