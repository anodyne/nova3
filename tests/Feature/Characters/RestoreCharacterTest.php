<?php

declare(strict_types=1);

use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Support\Facades\Event;
use Nova\Characters\Events\CharacterRestored;
use Nova\Characters\Livewire\CharactersList;
use Nova\Characters\Models\Character;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ForceDeleteAction;
use Nova\Foundation\Filament\Actions\RestoreAction;
use Nova\Foundation\Filament\Actions\RestoreBulkAction;
use Nova\Foundation\Filament\Actions\ViewAction;

use function Pest\Laravel\assertNotSoftDeleted;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

uses()->group('characters');

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'character.restore');
    });

    test('can restore a soft deleted character', function () {
        Event::fake();

        $character = Character::factory()->active()->trashed()->create();

        livewire(CharactersList::class)
            ->filterTable(TrashedFilter::class, false)
            ->assertCountTableRecords(1)
            ->assertTableActionVisible(RestoreAction::class, $character)
            ->callTableAction(RestoreAction::class, $character)
            ->assertNotified();

        assertNotSoftDeleted(Character::class, $character->only('id'));

        Event::assertDispatched(CharacterRestored::class);
    });

    test('can restore multiple soft deleted characters', function () {
        $characters = Character::factory(3)->trashed()->create();

        livewire(CharactersList::class)
            ->filterTable(TrashedFilter::class, false)
            ->assertCountTableRecords(3)
            ->callTableBulkAction(RestoreBulkAction::class, $characters)
            ->assertNotified();

        foreach ($characters as $character) {
            assertNotSoftDeleted(Character::class, $character->only('id'));
        }
    });

    test('has the correct permissions for list characters page', function () {
        $activeCharacter = Character::factory()->active()->create();
        $inactiveCharacter = Character::factory()->inactive()->create();
        $deletedCharacter = Character::factory()->active()->trashed()->create();

        livewire(CharactersList::class)
            ->filterTable(TrashedFilter::class, true)
            ->assertTableActionHidden(ViewAction::class, $activeCharacter)
            ->assertTableActionHidden(EditAction::class, $activeCharacter)
            ->assertTableActionHidden(DeleteAction::class, $activeCharacter)
            ->assertTableActionHidden(ForceDeleteAction::class, $activeCharacter)
            ->assertTableActionHidden(RestoreAction::class, $activeCharacter)
            ->assertTableActionHidden('activateCharacter', $activeCharacter)
            ->assertTableActionHidden('deactivateCharacter', $activeCharacter)
            ->assertTableActionHidden(ViewAction::class, $inactiveCharacter)
            ->assertTableActionHidden(EditAction::class, $inactiveCharacter)
            ->assertTableActionHidden(DeleteAction::class, $inactiveCharacter)
            ->assertTableActionHidden(ForceDeleteAction::class, $inactiveCharacter)
            ->assertTableActionHidden(RestoreAction::class, $inactiveCharacter)
            ->assertTableActionHidden('activateCharacter', $inactiveCharacter)
            ->assertTableActionHidden('deactivateCharacter', $inactiveCharacter)
            ->assertTableActionHidden(ViewAction::class, $deletedCharacter)
            ->assertTableActionHidden(EditAction::class, $deletedCharacter)
            ->assertTableActionHidden(DeleteAction::class, $deletedCharacter)
            ->assertTableActionHidden(ForceDeleteAction::class, $deletedCharacter)
            ->assertTableActionVisible(RestoreAction::class, $deletedCharacter)
            ->assertTableActionHidden('activateCharacter', $deletedCharacter)
            ->assertTableActionHidden('deactivateCharacter', $deletedCharacter);
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot restore a soft deleted character', function () {
        $character = Character::factory()->active()->trashed()->create();

        livewire(CharactersList::class)
            ->assertTableActionHidden(RestoreAction::class, $character);
    });

    test('cannot restore multiple soft deleted characters', function () {
        $characters = Character::factory(3)->active()->trashed()->create();

        livewire(CharactersList::class)
            ->assertTableBulkActionHidden(RestoreBulkAction::class, $characters);
    });

    test('has the correct permissions for list characters page', function () {
        $activeCharacter = Character::factory()->active()->create();
        $inactiveCharacter = Character::factory()->inactive()->create();
        $deletedCharacter = Character::factory()->active()->trashed()->create();

        livewire(CharactersList::class)
            ->assertTableActionHidden(ViewAction::class, $activeCharacter)
            ->assertTableActionHidden(EditAction::class, $activeCharacter)
            ->assertTableActionHidden(DeleteAction::class, $activeCharacter)
            ->assertTableActionHidden(ForceDeleteAction::class, $activeCharacter)
            ->assertTableActionHidden(RestoreAction::class, $activeCharacter)
            ->assertTableActionHidden('activateCharacter', $activeCharacter)
            ->assertTableActionHidden('deactivateCharacter', $activeCharacter)
            ->assertTableActionHidden(ViewAction::class, $inactiveCharacter)
            ->assertTableActionHidden(EditAction::class, $inactiveCharacter)
            ->assertTableActionHidden(DeleteAction::class, $inactiveCharacter)
            ->assertTableActionHidden(ForceDeleteAction::class, $inactiveCharacter)
            ->assertTableActionHidden(RestoreAction::class, $inactiveCharacter)
            ->assertTableActionHidden('activateCharacter', $inactiveCharacter)
            ->assertTableActionHidden('deactivateCharacter', $inactiveCharacter)
            ->assertTableActionHidden(ViewAction::class, $deletedCharacter)
            ->assertTableActionHidden(EditAction::class, $deletedCharacter)
            ->assertTableActionHidden(DeleteAction::class, $deletedCharacter)
            ->assertTableActionHidden(ForceDeleteAction::class, $deletedCharacter)
            ->assertTableActionHidden(RestoreAction::class, $deletedCharacter)
            ->assertTableActionHidden('activateCharacter', $deletedCharacter)
            ->assertTableActionHidden('deactivateCharacter', $deletedCharacter);
    });
});

describe('unauthenticated user', function () {
    test('cannot restore a soft deleted character', function () {
        get(route('characters.index'))
            ->assertRedirectToRoute('login');
    });
});
