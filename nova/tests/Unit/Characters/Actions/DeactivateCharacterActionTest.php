<?php

namespace Tests\Unit\Characters\Actions;

use Tests\TestCase;
use Nova\Characters\Models\Character;
use Nova\Departments\Models\Position;
use Nova\Characters\Actions\DeactivateCharacter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Characters\Models\States\Statuses\Inactive;

/**
 * @group characters
 * @group positions
 */
class DeactivateCharacterActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $character;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(DeactivateCharacter::class);

        $this->character = create(Character::class, [], ['status:active']);
    }

    /** @test **/
    public function itDeactivatesACharacter()
    {
        $character = $this->action->execute($this->character);

        $this->assertTrue($character->status->equals(Inactive::class));
    }

    /** @test **/
    public function itAddsPositionAvailabilityWhenPrimaryCharacterIsDeactivated()
    {
        $position = create(Position::class, [
            'available' => 0,
        ]);

        $this->character->positions()->attach($position, ['primary' => true]);

        $this->character->refresh();

        $this->action->execute($this->character);

        $position->refresh();

        $this->assertEquals(1, $position->available);
    }

    /** @test **/
    public function itDoesNotAddPositionAvailabilityWhenProtectedNpcIsDeactivated()
    {
        $position = create(Position::class, [
            'available' => 0,
        ]);

        $this->character->positions()->attach($position);

        $character = $this->action->execute($this->character);

        $position->fresh();

        $this->assertEquals(0, $position->available);
    }

    /** @test **/
    public function itDoesNotAddPositionAvailabilityWhenNpcIsDeactivated()
    {
        $position = create(Position::class, [
            'available' => 0,
        ]);

        $this->character->positions()->attach($position);

        $character = $this->action->execute($this->character);

        $position->fresh();

        $this->assertEquals(0, $position->available);
    }
}
