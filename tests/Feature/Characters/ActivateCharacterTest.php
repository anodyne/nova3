<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Characters\Events\CharacterActivated;
use Nova\Characters\Livewire\CharactersList;
use Nova\Characters\Models\Character;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;

uses()->group('characters');

beforeEach(function () {
    signIn(permissions: 'character.activate');

    $this->character = Character::factory()->inactive()->create();
});

test('an inactive character can be activated', function () {
    Event::fake();

    livewire(CharactersList::class)
        ->assertTableActionVisible('activate', $this->character)
        ->callTableAction('activate', $this->character)
        ->assertNotified();

    assertDatabaseHas(Character::class, [
        'id' => $this->character->id,
        'status' => 'active',
    ]);

    Event::assertDispatched(CharacterActivated::class);
});
