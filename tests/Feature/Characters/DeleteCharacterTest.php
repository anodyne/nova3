<?php

declare(strict_types=1);

use Filament\Actions\Testing\TestAction;
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
            ->callAction(TestAction::make(DeleteAction::class)->table($character))
            ->assertCanNotSeeTableRecords([$character])
            ->assertNotified();

        assertSoftDeleted(Character::class, $character->only('id'));

        Event::assertDispatched(CharacterDeleted::class);
        Event::assertDispatched(CharacterDeletedByAdmin::class);
    });

    test('can soft delete multiple characters', function () {
        $characters = Character::factory(3)->create();

        livewire(CharactersList::class)
            ->selectTableRecords($characters)
            ->callAction(TestAction::make(DeleteBulkAction::class)->table()->bulk())
            ->assertCanNotSeeTableRecords($characters)
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
            ->callAction(TestAction::make(ForceDeleteAction::class)->table($character))
            ->assertCanNotSeeTableRecords([$character])
            ->assertNotified();

        assertDatabaseMissing(Character::class, $character->only('id'));

        Event::assertDispatched(CharacterForceDeleted::class);
    });

    test('can force delete multiple soft deleted characters', function () {
        $characters = Character::factory(3)->trashed()->create();

        livewire(CharactersList::class)
            ->filterTable(TrashedFilter::class, false)
            ->selectTableRecords($characters)
            ->callAction(TestAction::make(ForceDeleteBulkAction::class)->table()->bulk())
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
            ->removeTableFilters()
            ->filterTable(TrashedFilter::class, true)
            ->assertActionHidden(TestAction::make(ViewAction::class)->table($activeCharacter))
            ->assertActionHidden(TestAction::make(EditAction::class)->table($activeCharacter))
            ->assertActionVisible(TestAction::make(DeleteAction::class)->table($activeCharacter))
            ->assertActionHidden(TestAction::make(ForceDeleteAction::class)->table($activeCharacter))
            ->assertActionHidden(TestAction::make(RestoreAction::class)->table($activeCharacter))
            ->assertActionHidden(TestAction::make('activateCharacter')->table($activeCharacter))
            ->assertActionHidden(TestAction::make('deactivateCharacter')->table($activeCharacter))
            ->assertActionHidden(TestAction::make(ViewAction::class)->table($inactiveCharacter))
            ->assertActionHidden(TestAction::make(EditAction::class)->table($inactiveCharacter))
            ->assertActionVisible(TestAction::make(DeleteAction::class)->table($inactiveCharacter))
            ->assertActionHidden(TestAction::make(ForceDeleteAction::class)->table($inactiveCharacter))
            ->assertActionHidden(TestAction::make(RestoreAction::class)->table($inactiveCharacter))
            ->assertActionHidden(TestAction::make('activateCharacter')->table($inactiveCharacter))
            ->assertActionHidden(TestAction::make('deactivateCharacter')->table($inactiveCharacter))
            ->assertActionHidden(TestAction::make(ViewAction::class)->table($deletedCharacter))
            ->assertActionHidden(TestAction::make(EditAction::class)->table($deletedCharacter))
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($deletedCharacter))
            ->assertActionVisible(TestAction::make(ForceDeleteAction::class)->table($deletedCharacter))
            ->assertActionHidden(TestAction::make(RestoreAction::class)->table($deletedCharacter))
            ->assertActionHidden(TestAction::make('activateCharacter')->table($deletedCharacter))
            ->assertActionHidden(TestAction::make('deactivateCharacter')->table($deletedCharacter));
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot soft delete a character', function () {
        $character = Character::factory()->active()->create();

        livewire(CharactersList::class)
            ->assertCanNotSeeTableRecords([$character]);
    });

    test('cannot soft delete multiple characters', function () {
        $characters = Character::factory(3)->create();

        livewire(CharactersList::class)
            ->assertCanNotSeeTableRecords($characters);
    });

    test('cannot force delete a soft deleted character', function () {
        $character = Character::factory()->active()->trashed()->create();

        livewire(CharactersList::class)
            ->filterTable(TrashedFilter::class, false)
            ->assertCanNotSeeTableRecords([$character]);
    });

    test('cannot force delete multiple soft deleted characters', function () {
        $characters = Character::factory(3)->trashed()->create();

        livewire(CharactersList::class)
            ->filterTable(TrashedFilter::class, false)
            ->assertCanNotSeeTableRecords($characters);
    });

    it('has the correct permissions for list characters page', function () {
        $activeCharacter = Character::factory()->active()->create();
        $inactiveCharacter = Character::factory()->inactive()->create();
        $deletedCharacter = Character::factory()->active()->trashed()->create();

        livewire(CharactersList::class)
            ->removeTableFilters()
            ->filterTable(TrashedFilter::class, true)
            ->assertCanNotSeeTableRecords([$activeCharacter, $inactiveCharacter, $deletedCharacter]);
    });
});

describe('unauthenticated user', function () {
    test('cannot delete an active character', function () {
        get(route('admin.characters.index'))
            ->assertRedirectToRoute('login');
    });
});
