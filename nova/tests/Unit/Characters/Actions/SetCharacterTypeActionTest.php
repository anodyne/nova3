<?php

declare(strict_types=1);

namespace Tests\Unit\Characters\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Characters\Actions\SetCharacterType;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Types\Primary;
use Nova\Characters\Models\States\Types\Secondary;
use Nova\Users\Models\User;
use Tests\TestCase;

/**
 * @group characters
 */
class SetCharacterTypeActionTest extends TestCase
{
    use RefreshDatabase;

    protected $character;

    public function setUp(): void
    {
        parent::setUp();

        $this->character = Character::factory()->create();
    }

    /** @test **/
    public function itCanSetCharacterAsSecondaryCharacter()
    {
        $user = User::factory()->active()->create();
        $this->character->users()->attach($user);

        $character = SetCharacterType::run($this->character);

        $this->assertInstanceOf(Secondary::class, $character->type);
    }

    /** @test **/
    public function itCanSetCharacterAsPrimaryCharacter()
    {
        $user = User::factory()->active()->create();
        $this->character->users()->attach($user, ['primary' => true]);

        $character = SetCharacterType::run($this->character);

        $this->assertInstanceOf(Primary::class, $character->type);
    }
}
