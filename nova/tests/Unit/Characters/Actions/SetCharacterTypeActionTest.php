<?php

namespace Tests\Unit\Characters\Actions;

use Tests\TestCase;
use Nova\Users\Models\User;
use Nova\Characters\Models\Character;
use Nova\Characters\Actions\SetCharacterType;
use Nova\Characters\Models\States\Types\Primary;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Characters\Models\States\Types\Secondary;

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

        $this->character = create(Character::class);
    }

    /** @test **/
    public function itCanSetCharacterAsSecondaryCharacter()
    {
        $user = create(User::class, [], ['status:active']);
        $this->character->users()->attach($user);

        $character = $this->action->execute($this->character);

        $this->assertTrue($character->type->equals(Secondary::class));
    }

    /** @test **/
    public function itCanSetCharacterAsPrimaryCharacter()
    {
        $user = create(User::class, [], ['status:active']);
        $this->character->users()->attach($user, ['primary' => true]);

        $character = $this->action->execute($this->character);

        $this->assertTrue($character->type->equals(Primary::class));
    }
}
