<?php

declare(strict_types=1);

use Filament\Actions\Testing\TestAction;
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
            ->removeTableFilters()
            ->filterTable(TrashedFilter::class, false)
            ->assertCanSeeTableRecords([$character])
            ->callAction(TestAction::make(RestoreAction::class)->table($character))
            ->assertNotified();

        assertNotSoftDeleted(Character::class, $character->only('id'));

        Event::assertDispatched(CharacterRestored::class);
    });

    test('can restore multiple soft deleted characters', function () {
        $characters = Character::factory(3)->trashed()->create();

        livewire(CharactersList::class)
            ->removeTableFilters()
            ->filterTable(TrashedFilter::class, false)
            ->assertCanSeeTableRecords($characters)
            ->selectTableRecords($characters)
            ->callAction(TestAction::make(RestoreBulkAction::class)->table()->bulk())
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
            ->removeTableFilters()
            ->filterTable(TrashedFilter::class, true)
            ->assertCanSeeTableRecords([$activeCharacter, $inactiveCharacter, $deletedCharacter])
            ->assertActionHidden(TestAction::make(ViewAction::class)->table($activeCharacter))
            ->assertActionHidden(TestAction::make(EditAction::class)->table($activeCharacter))
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($activeCharacter))
            ->assertActionHidden(TestAction::make(ForceDeleteAction::class)->table($activeCharacter))
            ->assertActionHidden(TestAction::make(RestoreAction::class)->table($activeCharacter))
            ->assertActionHidden(TestAction::make('activateCharacter')->table($activeCharacter))
            ->assertActionHidden(TestAction::make('deactivateCharacter')->table($activeCharacter))
            ->assertActionHidden(TestAction::make(ViewAction::class)->table($inactiveCharacter))
            ->assertActionHidden(TestAction::make(EditAction::class)->table($inactiveCharacter))
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($inactiveCharacter))
            ->assertActionHidden(TestAction::make(ForceDeleteAction::class)->table($inactiveCharacter))
            ->assertActionHidden(TestAction::make(RestoreAction::class)->table($inactiveCharacter))
            ->assertActionHidden(TestAction::make('activateCharacter')->table($inactiveCharacter))
            ->assertActionHidden(TestAction::make('deactivateCharacter')->table($inactiveCharacter))
            ->assertActionHidden(TestAction::make(ViewAction::class)->table($deletedCharacter))
            ->assertActionHidden(TestAction::make(EditAction::class)->table($deletedCharacter))
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($deletedCharacter))
            ->assertActionHidden(TestAction::make(ForceDeleteAction::class)->table($deletedCharacter))
            ->assertActionVisible(TestAction::make(RestoreAction::class)->table($deletedCharacter))
            ->assertActionHidden(TestAction::make('activateCharacter')->table($deletedCharacter))
            ->assertActionHidden(TestAction::make('deactivateCharacter')->table($deletedCharacter));
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot restore a soft deleted character', function () {
        $character = Character::factory()->active()->trashed()->create();

        livewire(CharactersList::class)
            ->assertCanNotSeeTableRecords([$character]);
    });

    test('cannot restore multiple soft deleted characters', function () {
        $characters = Character::factory(3)->active()->trashed()->create();

        livewire(CharactersList::class)
            ->assertCanNotSeeTableRecords($characters);
    });

    test('has the correct permissions for list characters page', function () {
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
    test('cannot restore a soft deleted character', function () {
        get(route('admin.characters.index'))
            ->assertRedirectToRoute('login');
    });
});
