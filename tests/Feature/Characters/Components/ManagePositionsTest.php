<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Collection;
use Nova\Characters\Livewire\ManagePositions;
use Nova\Characters\Models\Character;
use Nova\Departments\Models\Position;

use function Pest\Livewire\livewire;

uses()->group('characters');
uses()->group('components');

it('can mount without a character', function () {
    livewire(ManagePositions::class)
        ->assertOk()
        ->assertSet('character', null)
        ->assertSet('assigned', Collection::make());
});

it('can mount with a character', function () {
    $character = Character::factory()
        ->active()
        ->has(Position::factory(), 'positions')
        ->create();

    livewire(ManagePositions::class, ['character' => $character])
        ->assertOk()
        ->assertSet('character', $character)
        ->assertSet('assigned', $character->positions);
});

it('can search positions', function () {
    Position::factory()->create(['name' => 'Test position']);

    livewire(ManagePositions::class)
        ->set('search', 'test')
        ->assertSet('searchResults', $positions = Position::searchFor('test')->get())
        ->assertCount('searchResults', $positions->count());
});

it('can list all positions in the search results', function () {
    livewire(ManagePositions::class)
        ->set('search', '*')
        ->assertSet('searchResults', $positions = Position::get())
        ->assertCount('searchResults', $positions->count());
});

it('can add a position', function () {
    $position1 = Position::factory()->create();
    $position2 = Position::factory()->create();

    livewire(ManagePositions::class)
        ->call('add', $position1->id)
        ->call('add', $position2->id)
        ->assertSet('assignedPositions', "{$position1->id},{$position2->id}");
});

it('can remove a position', function () {
    $position1 = Position::factory()->create();
    $position2 = Position::factory()->create();

    livewire(ManagePositions::class)
        ->call('add', $position1->id)
        ->call('add', $position2->id)
        ->assertSet('assignedPositions', "{$position1->id},{$position2->id}")
        ->call('remove', $position1->id)
        ->assertSet('assignedPositions', "{$position2->id}");
});
