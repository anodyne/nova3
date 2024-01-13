<?php

declare(strict_types=1);

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
        signIn(permissions: 'character.activate');
    });

    test('can activate an inactive character', function () {
        Event::fake();

        $character = Character::factory()->inactive()->create();

        livewire(CharactersList::class)
            ->callTableAction('activate', $character)
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
            ->callTableBulkAction('bulk_activate', $characters)
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
            ->assertTableActionVisible('activate', $inactiveCharacter)
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

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot activate an inactive character', function () {
        $character = Character::factory()->inactive()->create();

        livewire(CharactersList::class)
            ->assertTableActionHidden('activate', $character);

        assertDatabaseHas(Character::class, [
            'id' => $character->id,
            'status' => 'inactive',
        ]);
    });

    test('cannot activate multiple inactive characters', function () {
        $characters = Character::factory(3)->inactive()->create();

        livewire(CharactersList::class)
            ->assertTableBulkActionHidden('bulk_activate', $characters);

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
    test('cannot activate an inactive character', function () {
        get(route('characters.index'))->assertRedirectToRoute('login');
    });
});
