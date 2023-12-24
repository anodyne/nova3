<?php

declare(strict_types=1);

use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Support\Facades\Event;
use Nova\Characters\Events\CharacterDeleted;
use Nova\Characters\Events\CharacterDeletedByAdmin;
use Nova\Characters\Events\CharacterForceDeleted;
use Nova\Characters\Livewire\CharactersList;
use Nova\Characters\Models\Character;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\DeleteBulkAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ForceDeleteAction;
use Nova\Foundation\Filament\Actions\ForceDeleteBulkAction;
use Nova\Foundation\Filament\Actions\RestoreAction;
use Nova\Foundation\Filament\Actions\ViewAction;

use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\assertSoftDeleted;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

uses()->group('characters');

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'character.delete');
    });

    test('can soft delete a character', function () {
        Event::fake();

        $character = Character::factory()->active()->create();

        livewire(CharactersList::class)
            ->callTableAction(DeleteAction::class, $character)
            ->assertCanNotSeeTableRecords([$character])
            ->assertNotified();

        assertSoftDeleted(Character::class, $character->only('id'));

        Event::assertDispatched(CharacterDeleted::class);
        Event::assertDispatched(CharacterDeletedByAdmin::class);
    });

    test('can soft delete multiple characters', function () {
        $characters = Character::factory(3)->create();

        livewire(CharactersList::class)
            ->callTableBulkAction(DeleteBulkAction::class, $characters)
            ->assertNotified();

        foreach ($characters as $character) {
            assertSoftDeleted(Character::class, $character->only('id'));
        }
    });

    test('can force delete a soft deleted character', function () {
        Event::fake();

        $character = Character::factory()->active()->trashed()->create();

        livewire(CharactersList::class)
            ->filterTable(TrashedFilter::class, false)
            ->callTableAction(ForceDeleteAction::class, $character)
            ->assertCanNotSeeTableRecords([$character])
            ->assertNotified();

        assertDatabaseMissing(Character::class, $character->only('id'));

        Event::assertDispatched(CharacterForceDeleted::class);
    });

    test('can force delete multiple soft deleted characters', function () {
        $characters = Character::factory(3)->trashed()->create();

        livewire(CharactersList::class)
            ->filterTable(TrashedFilter::class, false)
            ->callTableBulkAction(ForceDeleteBulkAction::class, $characters)
            ->assertCanNotSeeTableRecords($characters)
            ->assertNotified();

        foreach ($characters as $character) {
            assertDatabaseMissing(Character::class, $character->only('id'));
        }
    });

    it('has the correct permissions for list characters page', function () {
        $activeCharacter = Character::factory()->active()->create();
        $inactiveCharacter = Character::factory()->inactive()->create();
        $deletedCharacter = Character::factory()->active()->trashed()->create();

        livewire(CharactersList::class)
            ->assertTableHeaderActionsExistInOrder([])
            ->assertTableActionHidden(ViewAction::class, $activeCharacter)
            ->assertTableActionHidden(EditAction::class, $activeCharacter)
            ->assertTableActionVisible(DeleteAction::class, $activeCharacter)
            ->assertTableActionHidden(ForceDeleteAction::class, $activeCharacter)
            ->assertTableActionHidden(RestoreAction::class, $activeCharacter)
            ->assertTableActionHidden('activate', $activeCharacter)
            ->assertTableActionHidden('deactivate', $activeCharacter)
            ->assertTableActionHidden(ViewAction::class, $inactiveCharacter)
            ->assertTableActionHidden(EditAction::class, $inactiveCharacter)
            ->assertTableActionVisible(DeleteAction::class, $inactiveCharacter)
            ->assertTableActionHidden(ForceDeleteAction::class, $inactiveCharacter)
            ->assertTableActionHidden(RestoreAction::class, $inactiveCharacter)
            ->assertTableActionHidden('activate', $inactiveCharacter)
            ->assertTableActionHidden('deactivate', $inactiveCharacter)
            ->assertTableActionHidden(ViewAction::class, $deletedCharacter)
            ->assertTableActionHidden(EditAction::class, $deletedCharacter)
            ->assertTableActionHidden(DeleteAction::class, $deletedCharacter)
            ->assertTableActionVisible(ForceDeleteAction::class, $deletedCharacter)
            ->assertTableActionHidden(RestoreAction::class, $deletedCharacter)
            ->assertTableActionHidden('activate', $deletedCharacter)
            ->assertTableActionHidden('deactivate', $deletedCharacter);
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot soft delete a character', function () {
        $character = Character::factory()->active()->create();

        livewire(CharactersList::class)
            ->assertTableActionHidden(DeleteAction::class, $character);
    });

    test('cannot soft delete multiple characters', function () {
        $characters = Character::factory(3)->create();

        livewire(CharactersList::class)
            ->assertTableBulkActionHidden(DeleteBulkAction::class, $characters);
    });

    test('cannot force delete a soft deleted character', function () {
        $character = Character::factory()->active()->trashed()->create();

        livewire(CharactersList::class)
            ->filterTable(TrashedFilter::class, false)
            ->assertTableBulkActionHidden(ForceDeleteAction::class, $character);
    });

    test('cannot force delete multiple soft deleted characters', function () {
        $characters = Character::factory(3)->trashed()->create();

        livewire(CharactersList::class)
            ->filterTable(TrashedFilter::class, false)
            ->assertTableBulkActionHidden(ForceDeleteBulkAction::class, $characters);
    });

    it('has the correct permissions for list characters page', function () {
        $activeCharacter = Character::factory()->active()->create();
        $inactiveCharacter = Character::factory()->inactive()->create();
        $deletedCharacter = Character::factory()->active()->trashed()->create();

        livewire(CharactersList::class)
            ->assertTableHeaderActionsExistInOrder([])
            ->assertTableActionHidden(ViewAction::class, $activeCharacter)
            ->assertTableActionHidden(EditAction::class, $activeCharacter)
            ->assertTableActionHidden(DeleteAction::class, $activeCharacter)
            ->assertTableActionHidden(ForceDeleteAction::class, $activeCharacter)
            ->assertTableActionHidden(RestoreAction::class, $activeCharacter)
            ->assertTableActionHidden('activate', $activeCharacter)
            ->assertTableActionHidden('deactivate', $activeCharacter)
            ->assertTableActionHidden(ViewAction::class, $inactiveCharacter)
            ->assertTableActionHidden(EditAction::class, $inactiveCharacter)
            ->assertTableActionHidden(DeleteAction::class, $inactiveCharacter)
            ->assertTableActionHidden(ForceDeleteAction::class, $inactiveCharacter)
            ->assertTableActionHidden(RestoreAction::class, $inactiveCharacter)
            ->assertTableActionHidden('activate', $inactiveCharacter)
            ->assertTableActionHidden('deactivate', $inactiveCharacter)
            ->assertTableActionHidden(ViewAction::class, $deletedCharacter)
            ->assertTableActionHidden(EditAction::class, $deletedCharacter)
            ->assertTableActionHidden(DeleteAction::class, $deletedCharacter)
            ->assertTableActionHidden(ForceDeleteAction::class, $deletedCharacter)
            ->assertTableActionHidden(RestoreAction::class, $deletedCharacter)
            ->assertTableActionHidden('activate', $deletedCharacter)
            ->assertTableActionHidden('deactivate', $deletedCharacter);
    });
});

describe('unauthenticated user', function () {
    test('cannot delete an active character', function () {
        get(route('characters.index'))
            ->assertRedirectToRoute('login');
    });
});
