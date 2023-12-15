<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Characters\Events\CharacterActivated;
use Nova\Characters\Livewire\ActivateCharacterButton;
use Nova\Characters\Models\Character;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;

uses()->group('characters');
uses()->group('components');

beforeEach(function () {
    signIn(permissions: 'character.activate');

    $this->character = Character::factory()->inactive()->create();
});

test('an inactive character can be activated with the button', function () {
    Event::fake();

    livewire(ActivateCharacterButton::class)
        ->set('character', $this->character)
        ->call('activate');

    assertDatabaseHas(Character::class, [
        'id' => $this->character->id,
        'status' => 'active',
    ]);

    Event::assertDispatched(CharacterActivated::class);
});
