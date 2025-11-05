<?php

declare(strict_types=1);

use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Support\Facades\Auth;
use Nova\Characters\Enums\CharacterType;
use Nova\Characters\Livewire\CharactersList;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Status\Active;
use Nova\Characters\Models\States\Status\Inactive;
use Nova\Characters\Models\States\Status\Pending;

use function Pest\Laravel\get;
use function Pest\Livewire\livewire;
use function PHPUnit\Framework\assertCount;

uses()->group('characters');

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'character.create');

        $this->characters = Character::factory()
            ->count(3)
            ->sequence(
                ['status' => Pending::$name],
                ['status' => Active::$name],
                ['status' => Inactive::$name],
            )
            ->create();
    });

    test('can view the list characters page', function () {
        get(route('admin.characters.index'))->assertSuccessful();

        livewire(CharactersList::class)
            ->removeTableFilters()
            ->assertCountTableRecords(3)
            ->assertCanSeeTableRecords($this->characters);
    });

    test('can filter characters by status', function () {
        livewire(CharactersList::class)
            ->removeTableFilters()
            ->filterTable('status', Pending::$name)
            ->assertCanSeeTableRecords($this->characters->where('status', Pending::$name))
            ->assertCanNotSeeTableRecords($this->characters->where('status', '!=', Pending::$name))
            ->removeTableFilters()
            ->filterTable('status', Active::$name)
            ->assertCanSeeTableRecords($this->characters->where('status', Active::$name))
            ->assertCanNotSeeTableRecords($this->characters->where('status', '!=', Active::$name))
            ->removeTableFilters()
            ->filterTable('status', Inactive::$name)
            ->assertCanSeeTableRecords($this->characters->where('status', Inactive::$name))
            ->assertCanNotSeeTableRecords($this->characters->where('status', '!=', Inactive::$name));
    });

    test('can filter characters by type', function () {
        Character::factory(3)
            ->sequence(
                ['type' => CharacterType::Primary],
                ['type' => CharacterType::Secondary],
                ['type' => CharacterType::Support],
            )
            ->create();

        livewire(CharactersList::class)
            ->removeTableFilters()
            ->filterTable('type', [CharacterType::Primary->value])
            ->assertCanSeeTableRecords(Character::where('type', CharacterType::Primary)->get())
            ->assertCanNotSeeTableRecords(Character::where('type', '!=', CharacterType::Primary)->get())
            ->removeTableFilters()
            ->filterTable('type', [CharacterType::Secondary->value])
            ->assertCanSeeTableRecords(Character::where('type', CharacterType::Secondary)->get())
            ->assertCanNotSeeTableRecords(Character::where('type', '!=', CharacterType::Secondary)->get())
            ->removeTableFilters()
            ->filterTable('type', [CharacterType::Support->value])
            ->assertCanSeeTableRecords(Character::where('type', CharacterType::Support)->get())
            ->assertCanNotSeeTableRecords(Character::where('type', '!=', CharacterType::Support)->get());
    });

    test('can filter characters by trashed state', function () {
        $character = Character::factory()->trashed()->create();

        assertCount(4, Character::withTrashed()->get());

        livewire(CharactersList::class)
            ->removeTableFilters()
            ->assertCanNotSeeTableRecords([$character])
            ->filterTable(TrashedFilter::class, false)
            ->assertCanSeeTableRecords([$character]);
    });

    test('can search characters by name', function () {
        Character::factory()->create([
            'name' => 'John Doe',
        ]);

        livewire(CharactersList::class)
            ->searchTable('banana')
            ->assertCountTableRecords(0)
            ->resetTableFilters()
            ->searchTable('doe')
            ->assertCountTableRecords(1);
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('can view the manage characters page', function () {
        get(route('admin.characters.index'))->assertSuccessful();
    });

    test('can only see their own characters', function () {
        $characters = Character::factory(3)->hasAttached(Auth::user(), [], 'users')->create();

        $unassignedCharacters = Character::factory(3)->create();

        livewire(CharactersList::class)
            ->assertCanSeeTableRecords($characters)
            ->assertCanNotSeeTableRecords($unassignedCharacters);
    });
});

describe('unauthenticated user', function () {
    test('cannot view the manage characters page', function () {
        get(route('admin.characters.index'))
            ->assertRedirectToRoute('login');
    });
});
