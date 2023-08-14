<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Characters\Events\CharacterDeleted;
use Nova\Characters\Events\CharacterDeletedByAdmin;
use Nova\Characters\Livewire\CharactersList;
use Nova\Characters\Models\Character;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\DeleteBulkAction;
use function Pest\Laravel\assertSoftDeleted;
use function Pest\Laravel\getJson;
use function Pest\Livewire\livewire;

uses()->group('characters');

beforeEach(function () {
    $this->character = Character::factory()->active()->create();
});

describe('authorized user', function () {
    test('can delete a single character', function () {
        Event::fake();

        $this->signInWithPermission('character.delete');

        livewire(CharactersList::class)
            ->callTableAction(DeleteAction::class, $this->character)
            ->assertNotified();

        assertSoftDeleted(Character::class, [
            'id' => $this->character->id,
        ]);

        Event::assertDispatched(CharacterDeleted::class);
        Event::assertDispatched(CharacterDeletedByAdmin::class);
    });

    test('can delete multiple characters', function () {
        Event::fake();

        $this->signInWithPermission('character.delete');

        $characters = Character::factory()->count(3)->active()->create();

        livewire(CharactersList::class)
            ->callTableBulkAction(DeleteBulkAction::class, $characters)
            ->assertNotified();

        foreach ($characters as $character) {
            assertSoftDeleted(Character::class, [
                'id' => $character->id,
            ]);

            Event::assertDispatched(CharacterDeleted::class);
            Event::assertDispatched(CharacterDeletedByAdmin::class);
        }
    });

    test('can filter the list of characters to only deleted characters', function () {
        $this->signInWithPermission('character.delete');

        $deletedCharacter = Character::factory()->create();
        $deletedCharacter->delete();

        livewire(CharactersList::class)
            ->assertCountTableRecords(1)
            ->filterTable('trashed', false)
            ->assertCountTableRecords(1);
    });

    test('can filter the list of characters to include deleted characters', function () {
        $this->signInWithPermission('character.delete');

        $deletedCharacter = Character::factory()->create();
        $deletedCharacter->delete();

        livewire(CharactersList::class)
            ->assertCountTableRecords(1)
            ->filterTable('trashed', true)
            ->assertCountTableRecords(2);
    });
});

test('unauthorized user cannot delete a character', function () {
    $this->signIn();

    livewire(CharactersList::class)
        ->assertCanNotSeeTableRecords([$this->character])
        ->assertCountTableRecords(0)
        ->assertTableActionHidden(DeleteAction::class, $this->character);
})->skip(message: 'Fixed in Filament 3.0');

test('unauthenticated user cannot delete a character', function () {
    getJson(route('characters.index'))->assertUnauthorized();
});
