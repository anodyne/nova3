<?php

declare(strict_types=1);

use Nova\Characters\Actions\ActivateCharacter;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Status\Active;

uses()->group('characters');

it('can activate an inactive character', function () {
    $character = ActivateCharacter::run(
        Character::factory()->inactive()->create()
    );

    expect($character->status)->toBeInstanceOf(Active::class);
});

it('can activate a pending character', function () {
    $character = ActivateCharacter::run(
        Character::factory()->pending()->create()
    );

    expect($character->status)->toBeInstanceOf(Active::class);
});
