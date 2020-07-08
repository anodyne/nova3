<?php

namespace Tests\Unit\Characters\Actions;

use Tests\TestCase;
use Nova\Users\Models\User;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Types\Primary;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Characters\Actions\AssignCharacterOwners;
use Nova\Characters\Models\States\Types\Secondary;
use Nova\Characters\DataTransferObjects\AssignCharacterOwnersData;

/**
 * @group characters
 * @group users
 */
class AssignCharacterOwnersActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $character;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(AssignCharacterOwners::class);

        $this->character = create(Character::class, [], ['status:active']);
    }

    /** @test **/
    public function itAssignsOwnershipOfCharacterToUsers()
    {
        $john = create(User::class, [], ['status:active']);
        $jason = create(User::class, [], ['status:active']);

        $data = new AssignCharacterOwnersData;
        $data->users = [$john->id, $jason->id];
        $data->primaryCharacters = [];

        $character = $this->action->execute($this->character, $data);

        $john->refresh();
        $jason->refresh();

        $this->assertCount(2, $character->users);
        $this->assertCount(1, $john->characters->where('id', $this->character->id));
        $this->assertCount(1, $jason->characters->where('id', $this->character->id));
    }

    /** @test **/
    public function itCanSetPrimaryCharacterWhenAssigningOwnershipOfCharacterToUsers()
    {
        $john = create(User::class, [], ['status:active']);
        $jason = create(User::class, [], ['status:active']);

        $data = new AssignCharacterOwnersData;
        $data->users = [$john->id, $jason->id];
        $data->primaryCharacters = [$jason->id];

        $character = $this->action->execute($this->character, $data);

        $john->refresh();
        $jason->refresh();

        $this->assertTrue((bool) $jason->characters->first()->pivot->primary);
        $this->assertFalse((bool) $john->characters->first()->pivot->primary);
    }

    /** @test **/
    public function itChangesExistingPrimaryCharacterToSecondaryCharacterWhenACharacterIsMarkedAsAUsersNewPrimaryCharacter()
    {
        $jason = create(User::class, [], ['status:active']);

        $oldCharacter = create(Character::class, [], ['status:active']);
        $oldCharacter->users()->attach($jason, ['primary' => true]);
        $oldCharacter->type->transitionTo(Primary::class);

        $data = new AssignCharacterOwnersData;
        $data->users = [$jason->id];
        $data->primaryCharacters = [$jason->id];

        $character = $this->action->execute($this->character, $data);

        $jason->refresh();
        $oldCharacter->refresh();

        $this->assertCount(1, $jason->primaryCharacter);
        $this->assertTrue($jason->primaryCharacter->first()->is($this->character));
        $this->assertFalse($jason->primaryCharacter->first()->is($oldCharacter));
        $this->assertTrue($oldCharacter->type->equals(Secondary::class));
    }
}
