<?php

declare(strict_types=1);

namespace Tests\Unit\Characters\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Characters\Actions\DeactivateCharacter;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Statuses\Inactive;
use Tests\TestCase;

/**
 * @group characters
 */
class DeactivateCharacterActionTest extends TestCase
{
    use RefreshDatabase;

    protected $character;

    public function setUp(): void
    {
        parent::setUp();

        $this->character = Character::factory()->active()->create();
    }

    /** @test **/
    public function itDeactivatesACharacter()
    {
        $character = DeactivateCharacter::run($this->character);

        $this->assertInstanceOf(Inactive::class, $character->status);
    }
}
