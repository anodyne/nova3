<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Collection;
use Nova\Characters\Livewire\ManagePositions;
use Nova\Characters\Models\Character;
use Nova\Departments\Models\Position;

use function Pest\Livewire\livewire;

uses()->group('characters');
uses()->group('components');

beforeEach(fn () => signIn(permissions: 'character.create'));

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

it('can add a position', function () {
    $position1 = Position::factory()->create();
    $position2 = Position::factory()->create();

    livewire(ManagePositions::class)
        ->set('selected', (string) $position1->id)
        ->set('selected', (string) $position2->id)
        ->assertSet('assignedPositions', "{$position1->id},{$position2->id}");
});

it('can remove a position', function () {
    $position1 = Position::factory()->create();
    $position2 = Position::factory()->create();

    livewire(ManagePositions::class)
        ->set('selected', (string) $position1->id)
        ->set('selected', (string) $position2->id)
        ->call('remove', $position1->id)
        ->assertSet('assignedPositions', "{$position2->id}");
});
