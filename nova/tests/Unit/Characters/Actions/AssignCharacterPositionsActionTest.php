<?php

declare(strict_types=1);

namespace Tests\Unit\Characters\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Characters\Actions\AssignCharacterPositions;
use Nova\Characters\DataTransferObjects\AssignCharacterPositionsData;
use Nova\Characters\Models\Character;
use Nova\Departments\Models\Position;
use Tests\TestCase;

/**
 * @group characters
 * @group departments
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

        $this->character = Character::factory()->active()->create();
    }

    /** @test **/
    public function itAssignsOnePositionToACharacterWithoutAnyPositionsAndSetsItAsThePrimaryPosition()
    {
        $position = Position::factory()->create();

        $data = new AssignCharacterPositionsData([
            'positions' => [$position->id],
        ]);

        $character = $this->action->execute($this->character, $data);

        $position->refresh();

        $characterPositions = $character->positions;

        $this->assertCount(1, $characterPositions);
        $this->assertCount(1, $characterPositions->where('id', $position->id));
        $this->assertTrue((bool) $characterPositions->first()->pivot->primary);
    }

    /** @test **/
    public function itAssignsMultiplePositionsToACharacterWithoutAnyPositions()
    {
        $first = Position::factory()->create();
        $second = Position::factory()->create();

        $data = new AssignCharacterPositionsData([
            'positions' => [$first->id, $second->id],
        ]);

        $character = $this->action->execute($this->character, $data);

        $first->refresh();
        $second->refresh();

        $characterPositions = $character->positions;

        $this->assertCount(2, $characterPositions);
        $this->assertCount(1, $characterPositions->where('id', $first->id));
        $this->assertCount(1, $characterPositions->where('id', $second->id));
        $this->assertFalse((bool) $characterPositions[0]->pivot->primary);
        $this->assertFalse((bool) $characterPositions[1]->pivot->primary);
    }

    /** @test **/
    public function itAssignsMultiplePositionsToACharacterWithoutAnyPositionsAndSetsAPrimaryPosition()
    {
        $first = Position::factory()->create();
        $second = Position::factory()->create();

        $data = new AssignCharacterPositionsData([
            'positions' => [$first->id, $second->id],
            'primaryPosition' => $first->id,
        ]);

        $character = $this->action->execute($this->character, $data);

        $first->refresh();
        $second->refresh();

        $characterPositions = $character->positions;

        $this->assertCount(2, $characterPositions);
        $this->assertCount(1, $characterPositions->where('id', $first->id));
        $this->assertCount(1, $characterPositions->where('id', $second->id));
        $this->assertTrue((bool) $characterPositions[0]->pivot->primary);
        $this->assertFalse((bool) $characterPositions[1]->pivot->primary);
    }

    /** @test **/
    public function itAssignsOnePositionToACharacterWithADifferentPositionsAndSetsItAsThePrimaryPosition()
    {
        $first = Position::factory()->create();
        $second = Position::factory()->create();

        $this->character->positions()->attach($first);

        $data = new AssignCharacterPositionsData([
            'positions' => [$second->id],
        ]);

        $character = $this->action->execute($this->character, $data);

        $first->refresh();
        $second->refresh();

        $characterPositions = $character->positions;

        $this->assertCount(1, $characterPositions);
        $this->assertCount(0, $characterPositions->where('id', $first->id));
        $this->assertCount(1, $characterPositions->where('id', $second->id));
        $this->assertTrue((bool) $characterPositions->first()->pivot->primary);
    }

    /** @test **/
    public function itChangesOnePositionOfACharacterWithMultiplePositionsWithoutChangingThePrimaryPosition()
    {
        $first = Position::factory()->create();
        $second = Position::factory()->create();
        $third = Position::factory()->create();

        $this->character->positions()->attach($first);
        $this->character->positions()->attach($second, ['primary' => true]);

        $data = new AssignCharacterPositionsData([
            'positions' => [$second->id, $third->id],
            'primaryPosition' => $second->id,
        ]);

        $character = $this->action->execute($this->character, $data);

        $first->refresh();
        $second->refresh();
        $third->refresh();

        $characterPositions = $character->positions;

        $this->assertCount(2, $characterPositions);
        $this->assertCount(0, $characterPositions->where('id', $first->id));
        $this->assertCount(1, $characterPositions->where('id', $second->id));
        $this->assertCount(1, $characterPositions->where('id', $third->id));
        $this->assertTrue((bool) $characterPositions->where('id', $second->id)->first()->pivot->primary);
        $this->assertFalse((bool) $characterPositions->where('id', $third->id)->first()->pivot->primary);
    }

    /** @test **/
    public function itChangesOnePositionOfACharacterWithMultiplePositionsWhileChangingThePrimaryPosition()
    {
        $first = Position::factory()->create();
        $second = Position::factory()->create();
        $third = Position::factory()->create();

        $this->character->positions()->attach($first);
        $this->character->positions()->attach($second, ['primary' => true]);

        $data = new AssignCharacterPositionsData([
            'positions' => [$second->id, $third->id],
            'primaryPosition' => $third->id,
        ]);

        $character = $this->action->execute($this->character, $data);

        $first->refresh();
        $second->refresh();
        $third->refresh();

        $characterPositions = $character->positions;

        $this->assertCount(2, $characterPositions);
        $this->assertCount(0, $characterPositions->where('id', $first->id));
        $this->assertCount(1, $characterPositions->where('id', $second->id));
        $this->assertCount(1, $characterPositions->where('id', $third->id));
        $this->assertFalse((bool) $characterPositions->where('id', $second->id)->first()->pivot->primary);
        $this->assertTrue((bool) $characterPositions->where('id', $third->id)->first()->pivot->primary);
    }

    /** @test **/
    public function itChangesPositionsAndRemovesThePrimaryPosition()
    {
        $first = Position::factory()->create();
        $second = Position::factory()->create();
        $third = Position::factory()->create();

        $this->character->positions()->attach($first);
        $this->character->positions()->attach($second, ['primary' => true]);

        $data = new AssignCharacterPositionsData([
            'positions' => [$second->id, $third->id],
        ]);

        $character = $this->action->execute($this->character, $data);

        $first->refresh();
        $second->refresh();
        $third->refresh();

        $characterPositions = $character->positions;

        $this->assertCount(2, $characterPositions);
        $this->assertCount(0, $characterPositions->where('id', $first->id));
        $this->assertCount(1, $characterPositions->where('id', $second->id));
        $this->assertCount(1, $characterPositions->where('id', $third->id));
        $this->assertFalse((bool) $characterPositions->where('id', $second->id)->first()->pivot->primary);
        $this->assertFalse((bool) $characterPositions->where('id', $third->id)->first()->pivot->primary);
    }
}
