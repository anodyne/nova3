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
    public function itAssignsOneUserToACharacterWithoutAnyUsers()
    {
        $first = create(User::class, [], ['status:active']);

        $data = new AssignCharacterOwnersData([
            'users' => [$first->id],
        ]);

        $character = $this->action->execute($this->character, $data);

        $characterUsers = $character->users;

        $this->assertCount(1, $characterUsers);
        $this->assertCount(1, $characterUsers->where('id', $first->id));
        $this->assertFalse((bool) $characterUsers[0]->pivot->primary);
    }
}
