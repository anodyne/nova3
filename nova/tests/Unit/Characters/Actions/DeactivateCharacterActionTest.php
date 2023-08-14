<?php

declare(strict_types=1);
use Nova\Characters\Actions\DeactivateCharacter;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Status\Inactive;

uses()->group('characters');

it('can deactivate an active character', function () {
    $character = DeactivateCharacter::run(
        Character::factory()->active()->create()
    );

    expect($character->status)->toBeInstanceOf(Inactive::class);
});
it('can deactivate a pending character', function () {
    $character = DeactivateCharacter::run(
        Character::factory()->pending()->create()
    );

    expect($character->status)->toBeInstanceOf(Inactive::class);
});
