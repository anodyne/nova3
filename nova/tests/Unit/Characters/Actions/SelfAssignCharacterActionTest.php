<?php

declare(strict_types=1);

namespace Tests\Unit\Characters\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Characters\Actions\SelfAssignCharacter;
use Nova\Characters\Models\Character;
use Nova\Users\Models\User;
use Tests\TestCase;
use Tests\UsesSettings;

class SelfAssignCharacterActionTest extends TestCase
{
    use RefreshDatabase;
    use UsesSettings;

    protected Character $character;

    public function setUp(): void
    {
        parent::setUp();

        $this->character = Character::factory()->active()->create();
    }

    /** @test **/
    public function itCanAssignOwnershipOfTheCharacterToTheCreatingUser()
    {
        $this->updateSetting(
            fn ($settings) => $settings->characters->autoLinkCharacter = true
        );

        $this->signIn();

        $character = SelfAssignCharacter::run($this->character);

        $this->assertTrue(auth()->user()->is($character->users()->first()));
    }

    /** @test **/
    public function itCannotAssignOwnershipOfTheCharacterToSomeoneOtherThanTheCreatingUser()
    {
        $this->updateSetting(
            fn ($settings) => $settings->characters->autoLinkCharacter = true
        );

        $this->signIn();

        $user = User::factory()->active()->create();

        $user->characters()->sync([$this->character->id]);

        $character = SelfAssignCharacter::run($this->character);

        $this->assertCount(1, $character->users);
        $this->assertFalse($user->is($character->users()->first()));
    }

    /** @test **/
    public function itCannotAssignOwnershipOfTheCharacterIfAutoLinkCharactersSettingIsFalse()
    {
        $this->updateSetting(
            fn ($settings) => $settings->characters->autoLinkCharacter = false
        );

        $this->signIn();

        $character = SelfAssignCharacter::run($this->character);

        $this->assertCount(0, $character->users);
        $this->assertFalse(auth()->user()->is($character->users()->first()));
    }
}
