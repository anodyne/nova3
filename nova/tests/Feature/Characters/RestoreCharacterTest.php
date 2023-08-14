<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Characters\Events\CharacterRestored;
use Nova\Characters\Livewire\CharactersList;
use Nova\Characters\Models\Character;
use Nova\Foundation\Filament\Actions\RestoreAction;
use function Pest\Laravel\assertNotSoftDeleted;
use function Pest\Laravel\getJson;
use function Pest\Livewire\livewire;

uses()->group('characters');

beforeEach(function () {
    $this->character = Character::factory()->active()->create();
    $this->character->delete();
});

describe('authorized user', function () {
    test('can restore a deleted character', function () {
        Event::fake();

        $this->signInWithPermission('character.restore');

        livewire(CharactersList::class)
            ->filterTable('trashed', false)
            ->callTableAction(RestoreAction::class, $this->character)
            ->assertNotified();

        assertNotSoftDeleted(Character::class, [
            'id' => $this->character->id,
        ]);

        Event::assertDispatched(CharacterRestored::class);
    })->skip(message: 'Failing until Filament 3.0');

    test('can restore multiple deleted characters', function () {

    })->todo();
});

test('unauthorized user cannot restore a deleted character', function () {
    $this->signIn();

    livewire(CharactersList::class)
        ->assertCanNotSeeTableRecords([$this->character])
        ->assertCountTableRecords(0)
        ->assertTableActionHidden(RestoreAction::class, $this->character);
})->skip(message: 'Failing until Filament 3.0');

test('unauthorized user cannot restore multiple deleted characters', function () {

})->todo();

test('unauthenticated user cannot restore a deleted character', function () {
    getJson(route('characters.index'))->assertUnauthorized();
});
