<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Characters\Events\CharacterDeactivated;
use Nova\Characters\Livewire\DeactivateCharacterButton;
use Nova\Characters\Models\Character;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;

uses()->group('characters');
uses()->group('components');

beforeEach(function () {
    signIn(permissions: 'character.deactivate');

    $this->character = Character::factory()->active()->create();
});

test('an active character can be deactivated with the button', function () {
    Event::fake();

    livewire(DeactivateCharacterButton::class)
        ->set('character', $this->character)
        ->call('deactivate');

    assertDatabaseHas(Character::class, [
        'id' => $this->character->id,
        'status' => 'inactive',
    ]);

    Event::assertDispatched(CharacterDeactivated::class);
});
