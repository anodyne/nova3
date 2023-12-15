<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Characters\Events\CharacterDeactivated;
use Nova\Characters\Livewire\CharactersList;
use Nova\Characters\Models\Character;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;

uses()->group('characters');

beforeEach(function () {
    signIn(permissions: 'character.deactivate');

    $this->character = Character::factory()->active()->create();
});

test('an active character can be deactivated', function () {
    Event::fake();

    livewire(CharactersList::class)
        ->assertTableActionVisible('deactivate', $this->character)
        ->callTableAction('deactivate', $this->character)
        ->assertNotified();

    assertDatabaseHas(Character::class, [
        'id' => $this->character->id,
        'status' => 'inactive',
    ]);

    Event::assertDispatched(CharacterDeactivated::class);
});
