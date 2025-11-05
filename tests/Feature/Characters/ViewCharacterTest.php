<?php

declare(strict_types=1);

use Filament\Actions\Testing\TestAction;
use Filament\Tables\Filters\TrashedFilter;
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

        get(route('admin.characters.show', $character))
            ->assertSeeText($character->name)
            ->assertSuccessful();
    });

    test('has the correct permissions for list characters page', function () {
        $activeCharacter = Character::factory()->active()->create();
        $inactiveCharacter = Character::factory()->inactive()->create();
        $deletedCharacter = Character::factory()->active()->trashed()->create();

        livewire(CharactersList::class)
            ->removeTableFilters()
            ->filterTable(TrashedFilter::class, true)
            ->assertCanSeeTableRecords([$activeCharacter, $inactiveCharacter, $deletedCharacter])
            ->assertActionVisible(TestAction::make(ViewAction::class)->table($activeCharacter))
            ->assertActionHidden(TestAction::make(EditAction::class)->table($activeCharacter))
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($activeCharacter))
            ->assertActionHidden(TestAction::make(ForceDeleteAction::class)->table($activeCharacter))
            ->assertActionHidden(TestAction::make(RestoreAction::class)->table($activeCharacter))
            ->assertActionHidden(TestAction::make('activateCharacter')->table($activeCharacter))
            ->assertActionHidden(TestAction::make('deactivateCharacter')->table($activeCharacter))
            ->assertActionVisible(TestAction::make(ViewAction::class)->table($inactiveCharacter))
            ->assertActionHidden(TestAction::make(EditAction::class)->table($inactiveCharacter))
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($inactiveCharacter))
            ->assertActionHidden(TestAction::make(ForceDeleteAction::class)->table($inactiveCharacter))
            ->assertActionHidden(TestAction::make(RestoreAction::class)->table($inactiveCharacter))
            ->assertActionHidden(TestAction::make('activateCharacter')->table($inactiveCharacter))
            ->assertActionHidden(TestAction::make('deactivateCharacter')->table($inactiveCharacter))
            ->assertActionVisible(TestAction::make(ViewAction::class)->table($deletedCharacter))
            ->assertActionHidden(TestAction::make(EditAction::class)->table($deletedCharacter))
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($deletedCharacter))
            ->assertActionHidden(TestAction::make(ForceDeleteAction::class)->table($deletedCharacter))
            ->assertActionHidden(TestAction::make(RestoreAction::class)->table($deletedCharacter))
            ->assertActionHidden(TestAction::make('activateCharacter')->table($deletedCharacter))
            ->assertActionHidden(TestAction::make('deactivateCharacter')->table($deletedCharacter));
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the view character page', function () {
        $character = Character::factory()->active()->create();

        get(route('admin.characters.show', $character))
            ->assertForbidden();
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
    test('cannot view the view character page', function () {
        $character = Character::factory()->active()->create();

        get(route('admin.characters.show', $character))
            ->assertRedirectToRoute('login');
    });
});
