<?php

namespace Tests\Unit\Characters\Actions;

use Tests\TestCase;
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
}
