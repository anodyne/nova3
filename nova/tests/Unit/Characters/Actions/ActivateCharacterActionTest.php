<?php

namespace Tests\Unit\Characters\Actions;

use Tests\TestCase;
use Nova\Users\Models\User;
use Nova\Characters\Models\Character;
use Nova\Characters\Actions\ActivateCharacter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Characters\Models\States\Statuses\Active;

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
        $character = $this->action->execute($this->character);

        $this->assertTrue($character->status->equals(Active::class));
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
