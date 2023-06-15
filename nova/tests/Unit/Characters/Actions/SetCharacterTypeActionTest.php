<?php

declare(strict_types=1);

namespace Tests\Unit\Characters\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Characters\Actions\SetCharacterType;
use Nova\Characters\Enums\CharacterType;
use Nova\Characters\Models\Character;
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

        $this->assertEquals(CharacterType::secondary, $character->type);
    }

    /** @test **/
    public function itCanSetCharacterAsPrimaryCharacter()
    {
        $user = User::factory()->active()->create();
        $this->character->users()->attach($user, ['primary' => true]);

        $character = SetCharacterType::run($this->character);

        $this->assertEquals(CharacterType::primary, $character->type);
    }
}
