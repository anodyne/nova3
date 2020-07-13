<?php

namespace Tests\Unit\Characters\Actions;

use Tests\TestCase;
use Nova\Characters\Models\Character;
use Nova\Characters\Actions\DeactivateCharacter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Characters\Models\States\Statuses\Inactive;

/**
 * @group characters
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
}
