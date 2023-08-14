<?php

declare(strict_types=1);
use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Status\Active;
use Nova\Characters\Models\States\Status\Inactive as InactiveCharacter;
use Nova\Users\Models\States\Inactive;
use Nova\Users\Models\User;
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()
        ->active()
        ->hasAttached(
            Character::factory()->count(3)->active()
        )
        ->create();
});
it('deactivates characters when transitioning from active to inactive', function () {
    $this->user->status->transitionTo(Inactive::class);

    $this->user->refresh();

    expect(get_class($this->user->status))->toEqual(Inactive::class);

    $this->user->characters->each(function ($character) {
        expect(get_class($character->status))->toEqual(InactiveCharacter::class);
    });
});
it('only deactivates characters with one user when transitioning from active to inactive', function () {
    $user = User::factory()->active()->create();
    $character = Character::factory()->active()->create();
    $character->users()->saveMany([
        $user,
        $this->user,
    ]);

    $this->user->status->transitionTo(Inactive::class);

    $this->user->refresh();
    $character->fresh();

    expect(get_class($character->status))->toEqual(Active::class);

    expect(get_class($this->user->characters[0]->status))->toEqual(InactiveCharacter::class);
    expect(get_class($this->user->characters[1]->status))->toEqual(InactiveCharacter::class);
    expect(get_class($this->user->characters[2]->status))->toEqual(InactiveCharacter::class);
});
