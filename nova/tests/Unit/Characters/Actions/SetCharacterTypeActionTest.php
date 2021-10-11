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

    protected $action;

    protected $character;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(SetCharacterType::class);

        $this->character = Character::factory()->create();
    }

    /** @test **/
    public function itCanSetCharacterAsSecondaryCharacter()
    {
        $user = User::factory()->active()->create();
        $this->character->users()->attach($user);

        $character = $this->action->execute($this->character);

        $this->assertTrue($character->type->equals(Secondary::class));
    }

    /** @test **/
    public function itCanSetCharacterAsPrimaryCharacter()
    {
        $user = User::factory()->active()->create();
        $this->character->users()->attach($user, ['primary' => true]);

        $character = $this->action->execute($this->character);

        $this->assertTrue($character->type->equals(Primary::class));
    }
}
