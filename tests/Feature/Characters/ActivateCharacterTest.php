<?php

declare(strict_types=1);

use Filament\Actions\Testing\TestAction;
use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Nova\Characters\Events\CharacterActivated;
use Nova\Characters\Livewire\CharactersList;
use Nova\Characters\Models\Character;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ForceDeleteAction;
use Nova\Foundation\Filament\Actions\RestoreAction;
use Nova\Foundation\Filament\Actions\ViewAction;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

uses()->group('characters');

describe('authorized user', function () {
    beforeEach(function () {
        Event::fake();

        signIn(permissions: 'character.activate');
    });

    test('can activate an inactive character', function () {
        $character = Character::factory()->inactive()->create();

        livewire(CharactersList::class)
            ->removeTableFilters()
            ->assertCanSeeTableRecords([$character])
            ->callAction(TestAction::make('activateCharacter')->table($character))
            ->assertNotified();

        assertDatabaseHas(Character::class, [
            'id' => $character->id,
            'status' => 'active',
        ]);

        Event::assertDispatched(CharacterActivated::class);
    });

    test('can activate multiple inactive characters', function () {
        $characters = Character::factory(3)->inactive()->create();

        livewire(CharactersList::class)
            ->removeTableFilters()
            ->assertCanSeeTableRecords($characters)
            ->selectTableRecords($characters)
            ->callAction(TestAction::make('bulkActivateCharacter')->table()->bulk())
            ->assertNotified();

        foreach ($characters as $character) {
            assertDatabaseHas(Character::class, [
                'id' => $character->id,
                'status' => 'active',
            ]);
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
            ->assertActionVisible(TestAction::make('activateCharacter')->table($inactiveCharacter))
            ->assertActionHidden(TestAction::make('deactivateCharacter')->table($inactiveCharacter))
            ->assertActionHidden(TestAction::make(ViewAction::class)->table($deletedCharacter))
            ->assertActionHidden(TestAction::make(EditAction::class)->table($deletedCharacter))
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($deletedCharacter))
            ->assertActionHidden(TestAction::make(ForceDeleteAction::class)->table($deletedCharacter))
            ->assertActionHidden(TestAction::make(RestoreAction::class)->table($deletedCharacter))
            ->assertActionHidden(TestAction::make('activateCharacter')->table($deletedCharacter))
            ->assertActionHidden(TestAction::make('deactivateCharacter')->table($deletedCharacter));
    });
});

describe('activating character', function () {
    beforeEach(function () {
        Event::fake();

        signIn(permissions: 'character.activate');
    });

    test('cleans up primary character', function () {})->todo();
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();

        $character = Character::factory()->active()->create();
        $character->users()->attach(Auth::user());
    });

    test('cannot activate an inactive character', function () {
        $character = Character::factory()->inactive()->create();

        livewire(CharactersList::class)
            ->assertCanNotSeeTableRecords([$character]);

        assertDatabaseHas(Character::class, [
            'id' => $character->id,
            'status' => 'inactive',
        ]);
    });

    test('cannot activate multiple inactive characters', function () {
        $characters = Character::factory(3)->inactive()->create();

        livewire(CharactersList::class)
            ->assertCanNotSeeTableRecords($characters)
            ->selectTableRecords($characters)
            ->assertActionHidden(TestAction::make('bulkActivateCharacter')->table()->bulk());

        foreach ($characters as $character) {
            assertDatabaseHas(Character::class, [
                'id' => $character->id,
                'status' => 'inactive',
            ]);
        }
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
    test('cannot activate an inactive character', function () {
        get(route('admin.characters.index'))->assertRedirectToRoute('login');
    });
});
