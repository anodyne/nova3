<?php

namespace Tests\Unit\Characters\Actions;

use Tests\TestCase;
use Nova\Characters\Models\Character;
use Nova\Departments\Models\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Characters\Actions\AssignCharacterPositions;
use Nova\Characters\DataTransferObjects\AssignCharacterPositionsData;

/**
 * @group characters
 * @group positions
 */
class AssignCharacterPositionsActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $character;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(AssignCharacterPositions::class);

        $this->character = create(Character::class, [], ['status:active']);
    }

    /** @test **/
    public function itAssignsPositionsToCharacter()
    {
        $position1 = create(Position::class);
        $position2 = create(Position::class);

        $data = new AssignCharacterPositionsData;
        $data->positions = [$position1->id, $position2->id];

        $character = $this->action->execute($this->character, $data);

        $position1->refresh();
        $position2->refresh();

        $this->assertCount(2, $character->positions);
        $this->assertCount(1, $position1->characters->where('id', $this->character->id));
        $this->assertCount(1, $position2->characters->where('id', $this->character->id));
    }

    /** @test **/
    public function itCanSetPrimaryPositionWhenAssigningPositionsToCharacter()
    {
        $position1 = create(Position::class);
        $position2 = create(Position::class);

        $data = new AssignCharacterPositionsData;
        $data->positions = [$position1->id, $position2->id];
        $data->primaryPosition = $position1->id;

        $character = $this->action->execute($this->character, $data);

        $position1->refresh();
        $position2->refresh();

        $this->assertTrue((bool) $character->positions->where('id', $position1->id)->first()->pivot->primary);
        $this->assertFalse((bool) $character->positions->where('id', $position2->id)->first()->pivot->primary);
    }
}
