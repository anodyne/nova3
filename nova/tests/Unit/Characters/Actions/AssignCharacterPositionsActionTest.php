<?php

declare(strict_types=1);

namespace Tests\Unit\Characters\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Characters\Actions\AssignCharacterPositions;
use Nova\Characters\Data\AssignCharacterPositionsData;
use Nova\Characters\Models\Character;
use Nova\Departments\Models\Position;
use Tests\TestCase;

/**
 * @group characters
 * @group positions
 */
class AssignCharacterPositionsActionTest extends TestCase
{
    use RefreshDatabase;

    protected $character;

    public function setUp(): void
    {
        parent::setUp();

        $this->character = Character::factory()->active()->create();
    }

    /** @test **/
    public function itAssignsOnePositionToACharacterWithoutAnyPositionsAndSetsItAsThePrimaryPosition()
    {
        $position = Position::factory()->create();

        $data = AssignCharacterPositionsData::from([
            'positions' => [$position->id],
        ]);

        $character = AssignCharacterPositions::run($this->character, $data);

        $position->refresh();

        $this->assertCount(1, $character->positions);
        $this->assertCount(1, $character->primaryPosition);
        $this->assertTrue($character->positions->first()->is($position));
        $this->assertTrue($character->primaryPosition->first()->is($position));
    }

    /** @test **/
    public function itAssignsMultiplePositionsToACharacterWithoutAnyPositions()
    {
        $first = Position::factory()->create();
        $second = Position::factory()->create();

        $data = AssignCharacterPositionsData::from([
            'positions' => [$first->id, $second->id],
        ]);

        $character = AssignCharacterPositions::run($this->character, $data);

        $first->refresh();
        $second->refresh();

        $this->assertCount(2, $character->positions);
        $this->assertCount(0, $character->primaryPosition);
        $this->assertTrue($first->characters->first()->is($character));
        $this->assertTrue($second->characters->first()->is($character));
    }

    /** @test **/
    public function itAssignsMultiplePositionsToACharacterWithoutAnyPositionsAndSetsAPrimaryPosition()
    {
        $first = Position::factory()->create();
        $second = Position::factory()->create();

        $data = AssignCharacterPositionsData::from([
            'positions' => [$first->id, $second->id],
            'primaryPosition' => $first->id,
        ]);

        $character = AssignCharacterPositions::run($this->character, $data);

        $first->refresh();
        $second->refresh();

        $this->assertCount(2, $character->positions);
        $this->assertTrue($first->characters->first()->is($character));
        $this->assertTrue($second->characters->first()->is($character));
        $this->assertTrue($character->primaryPosition->first()->is($first));
        $this->assertFalse($character->primaryPosition->first()->is($second));
    }

    /** @test **/
    public function itAssignsOnePositionToACharacterWithADifferentPositionsAndSetsItAsThePrimaryPosition()
    {
        $first = Position::factory()->create();
        $second = Position::factory()->create();

        $this->character->positions()->attach($first);

        $data = AssignCharacterPositionsData::from([
            'positions' => [$second->id],
        ]);

        $character = AssignCharacterPositions::run($this->character, $data);

        $first->refresh();
        $second->refresh();

        $characterPositions = $character->positions;

        $this->assertCount(1, $character->positions);
        $this->assertCount(1, $character->primaryPosition);
        $this->assertFalse($character->positions->first()->is($first));
        $this->assertTrue($character->positions->first()->is($second));
        $this->assertFalse($character->primaryPosition->first()->is($first));
        $this->assertTrue($character->primaryPosition->first()->is($second));
    }

    /** @test **/
    public function itChangesOnePositionOfACharacterWithMultiplePositionsWithoutChangingThePrimaryPosition()
    {
        $first = Position::factory()->create();
        $second = Position::factory()->create();
        $third = Position::factory()->create();

        $this->character->positions()->attach($first);
        $this->character->positions()->attach($second, ['primary' => true]);
        $this->character->refresh();

        $this->assertCount(2, $this->character->positions);
        $this->assertCount(1, $this->character->primaryPosition);
        $this->assertFalse($this->character->primaryPosition->first()->is($first));
        $this->assertTrue($this->character->primaryPosition->first()->is($second));

        $data = AssignCharacterPositionsData::from([
            'positions' => [$second->id, $third->id],
            'primaryPosition' => $second->id,
        ]);

        $character = AssignCharacterPositions::run($this->character, $data);

        $first->refresh();
        $second->refresh();
        $third->refresh();

        $this->assertCount(2, $character->positions);
        $this->assertCount(1, $character->primaryPosition);
        $this->assertCount(0, $first->characters);
        $this->assertCount(1, $second->characters);
        $this->assertCount(1, $third->characters);
        $this->assertTrue($character->primaryPosition->first()->is($second));
        $this->assertFalse($character->primaryPosition->first()->is($third));
    }

    /** @test **/
    public function itChangesOnePositionOfACharacterWithMultiplePositionsWhileChangingThePrimaryPosition()
    {
        $first = Position::factory()->create();
        $second = Position::factory()->create();
        $third = Position::factory()->create();

        $this->character->positions()->attach($first);
        $this->character->positions()->attach($second, ['primary' => true]);
        $this->character->refresh();

        $this->assertCount(2, $this->character->positions);
        $this->assertCount(1, $this->character->primaryPosition);
        $this->assertFalse($this->character->primaryPosition->first()->is($first));
        $this->assertTrue($this->character->primaryPosition->first()->is($second));

        $data = AssignCharacterPositionsData::from([
            'positions' => [$second->id, $third->id],
            'primaryPosition' => $third->id,
        ]);

        $character = AssignCharacterPositions::run($this->character, $data);

        $first->refresh();
        $second->refresh();
        $third->refresh();

        $this->assertCount(2, $character->positions);
        $this->assertCount(1, $character->primaryPosition);
        $this->assertCount(0, $first->characters);
        $this->assertCount(1, $second->characters);
        $this->assertCount(1, $third->characters);
        $this->assertFalse($character->primaryPosition->first()->is($second));
        $this->assertTrue($character->primaryPosition->first()->is($third));
    }

    /** @test **/
    public function itChangesPositionsAndRemovesThePrimaryPosition()
    {
        $first = Position::factory()->create();
        $second = Position::factory()->create();
        $third = Position::factory()->create();

        $this->character->positions()->attach($first);
        $this->character->positions()->attach($second, ['primary' => true]);
        $this->character->refresh();

        $this->assertCount(2, $this->character->positions);
        $this->assertCount(1, $this->character->primaryPosition);
        $this->assertFalse($this->character->primaryPosition->first()->is($first));
        $this->assertTrue($this->character->primaryPosition->first()->is($second));

        $data = AssignCharacterPositionsData::from([
            'positions' => [$second->id, $third->id],
        ]);

        $character = AssignCharacterPositions::run($this->character, $data);

        $first->refresh();
        $second->refresh();
        $third->refresh();

        $this->assertCount(2, $character->positions);
        $this->assertCount(0, $character->primaryPosition);
        $this->assertCount(0, $first->characters);
        $this->assertCount(1, $second->characters);
        $this->assertCount(1, $third->characters);
    }
}
