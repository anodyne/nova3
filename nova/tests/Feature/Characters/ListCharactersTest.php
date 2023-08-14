<?php

declare(strict_types=1);

use Nova\Characters\Enums\CharacterType;
use Nova\Characters\Livewire\CharactersList;
use Nova\Characters\Models\Character;
use Nova\Foundation\Filament\Actions\CreateAction;
use function Pest\Laravel\getJson;
use function Pest\Livewire\livewire;

uses()->group('characters');

beforeEach(function () {
    $this->character1 = Character::factory()->active()->primary()->create([
        'name' => 'Liam Shaw',
    ]);

    $this->character2 = Character::factory()->inactive()->secondary()->create([
        'name' => 'Seven of Nine',
    ]);

    $this->character3 = Character::factory()->pending()->support()->create([
        'name' => 'Sidney LaForge',
    ]);
});

describe('authorized user', function () {
    test('can see all characters', function () {
        $this->signInWithPermission('character.create');

        livewire(CharactersList::class)
            ->assertCanSeeTableRecords([$this->character1, $this->character2, $this->character3])
            ->assertCountTableRecords(3)
            ->assertTableColumnExists('name')
            ->assertTableColumnExists('activeUsers.name')
            ->assertTableColumnExists('type')
            ->assertTableColumnExists('status');
    });

    test('can see the create button', function () {
        $this->signInWithPermission('character.create');

        livewire(CharactersList::class)
            ->assertTableHeaderActionsExistInOrder([
                CreateAction::class,
            ]);
    });

    test('can search all characters', function () {
        $this->signInWithPermission('character.create');

        livewire(CharactersList::class)
            ->assertCountTableRecords(3)
            ->searchTable('shaw')
            ->assertCountTableRecords(1)
            ->searchTable('nine')
            ->assertCountTableRecords(1)
            ->searchTable('foo')
            ->assertCountTableRecords(0);
    });

    test('can filter characters to only show my characters', function () {
        $this->signInWithPermission('character.create');

        $character4 = Character::factory()->hasAttached(auth()->user())->create([
            'name' => 'Jean Luc Picard',
        ]);

        $character5 = Character::factory()->hasAttached(auth()->user())->create([
            'name' => 'William Riker',
        ]);

        livewire(CharactersList::class)
            ->assertCountTableRecords(5)
            ->assertCanSeeTableRecords([$this->character1, $this->character2, $this->character3, $character4, $character5])
            ->filterTable('only_my_characters')
            ->assertCountTableRecords(2)
            ->assertCanSeeTableRecords([$character4, $character5]);
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        $this->signIn();

        $this->character4 = Character::factory()->hasAttached(auth()->user())->create([
            'name' => 'Jean Luc Picard',
        ]);

        $this->character5 = Character::factory()->hasAttached(auth()->user())->create([
            'name' => 'William Riker',
        ]);
    });

    test('can only see their own characters', function () {
        livewire(CharactersList::class)
            ->assertCountTableRecords(2)
            ->assertCanNotSeeTableRecords([$this->character1, $this->character2, $this->character3])
            ->assertCanSeeTableRecords([$this->character4, $this->character5]);
    });

    test('can only search their own characters', function () {
        livewire(CharactersList::class)
            ->assertCountTableRecords(2)
            ->searchTable('shaw')
            ->assertCountTableRecords(0)
            ->searchTable('nine')
            ->assertCountTableRecords(0)
            ->searchTable('foo')
            ->assertCountTableRecords(0)
            ->searchTable('picard')
            ->assertCountTableRecords(1)
            ->searchTable('william')
            ->assertCountTableRecords(1);
    });
});

test('can filter characters by type', function () {
    $this->signInWithPermission('character.create');

    livewire(CharactersList::class)
        ->assertCountTableRecords(3)
        ->filterTable('type', CharacterType::primary->value)
        ->assertCountTableRecords(1)
        ->assertCanSeeTableRecords([$this->character1])
        ->assertCanNotSeeTableRecords([$this->character2, $this->character3])
        ->filterTable('type', CharacterType::secondary->value)
        ->assertCountTableRecords(1)
        ->assertCanSeeTableRecords([$this->character2])
        ->assertCanNotSeeTableRecords([$this->character1, $this->character3])
        ->filterTable('type', CharacterType::support->value)
        ->assertCountTableRecords(1)
        ->assertCanSeeTableRecords([$this->character3])
        ->assertCanNotSeeTableRecords([$this->character1, $this->character2]);
});

test('can filter characters by status', function () {
    $this->signInWithPermission('character.create');

    livewire(CharactersList::class)
        ->assertCountTableRecords(3)
        ->filterTable('status', 'active')
        ->assertCountTableRecords(1)
        ->assertCanSeeTableRecords([$this->character1])
        ->assertCanNotSeeTableRecords([$this->character2, $this->character3])
        ->filterTable('status', 'inactive')
        ->assertCountTableRecords(1)
        ->assertCanSeeTableRecords([$this->character2])
        ->assertCanNotSeeTableRecords([$this->character1, $this->character3])
        ->filterTable('status', 'pending')
        ->assertCountTableRecords(1)
        ->assertCanSeeTableRecords([$this->character3])
        ->assertCanNotSeeTableRecords([$this->character1, $this->character2]);
});

test('unauthenticated user cannot view manage characters page', function () {
    getJson(route('characters.index'))->assertUnauthorized();
});
