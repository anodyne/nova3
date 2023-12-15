<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Nova\Characters\Events\CharacterDeleted;
use Nova\Characters\Livewire\CharactersList;
use Nova\Characters\Models\Character;
use Nova\Foundation\Filament\Actions\DeleteAction;

use function Pest\Laravel\assertSoftDeleted;
use function Pest\Livewire\livewire;

uses()->group('characters');

beforeEach(function () {
    signIn(permissions: 'character.delete');
});

test('an authorized user can delete a character', function () {
    Event::fake();

    $character = Character::factory()->active()->create();

    livewire(CharactersList::class)
        ->callTableAction(DeleteAction::class, $character)
        ->assertCanNotSeeTableRecords([$character])
        ->assertNotified();

    assertSoftDeleted(Character::class, $character->toArray());

    Event::assertDispatched(CharacterDeleted::class);
});

test('an authorized user cannot delete their own account', function () {
    livewire(CharactersList::class)
        ->assertTableActionHidden(DeleteAction::class, Auth::user());
});
