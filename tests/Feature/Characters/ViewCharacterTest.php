<?php

declare(strict_types=1);

use Nova\Characters\Livewire\CharactersList;
use Nova\Characters\Models\Character;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ForceDeleteAction;
use Nova\Foundation\Filament\Actions\RestoreAction;
use Nova\Foundation\Filament\Actions\ViewAction;

use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

uses()->group('characters');

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'character.view');
    });

    test('can view the view character page', function () {
        $character = Character::factory()->active()->create();

        get(route('characters.show', $character))
            ->assertSuccessful();
    });

    test('has the correct permissions for list characters page', function () {
        $activeCharacter = Character::factory()->active()->create();
        $inactiveCharacter = Character::factory()->inactive()->create();
        $deletedCharacter = Character::factory()->active()->trashed()->create();

        livewire(CharactersList::class)
            ->assertTableActionVisible(ViewAction::class, $activeCharacter)
            ->assertTableActionHidden(EditAction::class, $activeCharacter)
            ->assertTableActionHidden(DeleteAction::class, $activeCharacter)
            ->assertTableActionHidden(ForceDeleteAction::class, $activeCharacter)
            ->assertTableActionHidden(RestoreAction::class, $activeCharacter)
            ->assertTableActionHidden('activate', $activeCharacter)
            ->assertTableActionHidden('deactivate', $activeCharacter)
            ->assertTableActionVisible(ViewAction::class, $inactiveCharacter)
            ->assertTableActionHidden(EditAction::class, $inactiveCharacter)
            ->assertTableActionHidden(DeleteAction::class, $inactiveCharacter)
            ->assertTableActionHidden(ForceDeleteAction::class, $inactiveCharacter)
            ->assertTableActionHidden(RestoreAction::class, $inactiveCharacter)
            ->assertTableActionHidden('activate', $inactiveCharacter)
            ->assertTableActionHidden('deactivate', $inactiveCharacter)
            ->assertTableActionVisible(ViewAction::class, $deletedCharacter)
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

    test('cannot view the view character page', function () {
        $character = Character::factory()->active()->create();

        get(route('characters.show', $character))
            ->assertForbidden();
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
    test('cannot view the view character page', function () {
        $character = Character::factory()->active()->create();

        get(route('characters.show', $character))
            ->assertRedirectToRoute('login');
    });
});
