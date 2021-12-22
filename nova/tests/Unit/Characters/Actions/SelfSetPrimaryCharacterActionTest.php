<?php

declare(strict_types=1);

namespace Tests\Unit\Characters\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Characters\Actions\SelfSetPrimaryCharacter;
use Nova\Characters\Models\Character;
use Nova\Users\Models\User;
use Tests\TestCase;
use Tests\UsesSettings;

class SelfSetPrimaryCharacterActionTest extends TestCase
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
    public function itSetsThePrimaryCharacterToTheCreatingUser()
    {
        $this->updateSetting(
            fn ($settings) => $settings->characters->allowSettingPrimaryCharacter = true
        );

        $this->signIn();

        $this->character->users()->sync([auth()->id()]);

        $this->character->refresh();

        $character = SelfSetPrimaryCharacter::run($this->character);

        $this->assertTrue((bool) $character->users()->first()->pivot->primary);
    }

    /** @test **/
    public function itCannotSetThePrimaryCharacterToSomeoneOtherThanTheCreatingUser()
    {
        $this->updateSetting(
            fn ($settings) => $settings->characters->allowSettingPrimaryCharacter = true
        );

        $this->signIn();

        $user = User::factory()->active()->create();

        $this->character->users()->sync([$user->id]);

        $this->character->refresh();

        $character = SelfSetPrimaryCharacter::run($this->character);

        $this->assertFalse((bool) $character->users()->first()->pivot->primary);
    }

    /** @test **/
    public function itCannotSetThePrimaryCharacterToTheCreatingUserWhenAllowSettingPrimaryCharacterSettingIsFalse()
    {
        $this->updateSetting(
            fn ($settings) => $settings->characters->allowSettingPrimaryCharacter = false
        );

        $this->signIn();

        $this->character->users()->sync([auth()->id()]);

        $this->character->refresh();

        $character = SelfSetPrimaryCharacter::run($this->character);

        $this->assertFalse((bool) $character->users()->first()->pivot->primary);
    }
}
