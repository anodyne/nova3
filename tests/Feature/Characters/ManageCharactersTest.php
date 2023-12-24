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
        get(route('characters.index'))->assertSuccessful();

        livewire(CharactersList::class)
            ->assertCountTableRecords(3)
            ->assertCanSeeTableRecords($this->characters);
    });

    test('can filter characters by status', function () {
        livewire(CharactersList::class)
            ->filterTable('status', Pending::$name)
            ->assertCountTableRecords(1)
            ->assertCanSeeTableRecords($this->characters->where('status', Pending::$name))
            ->assertCanNotSeeTableRecords($this->characters->where('status', '!=', Pending::$name))
            ->resetTableFilters()
            ->filterTable('status', Active::$name)
            ->assertCountTableRecords(1)
            ->assertCanSeeTableRecords($this->characters->where('status', Active::$name))
            ->assertCanNotSeeTableRecords($this->characters->where('status', '!=', Active::$name))
            ->resetTableFilters()
            ->filterTable('status', Inactive::$name)
            ->assertCountTableRecords(1)
            ->assertCanSeeTableRecords($this->characters->where('status', Inactive::$name))
            ->assertCanNotSeeTableRecords($this->characters->where('status', '!=', Inactive::$name));
    });

    test('can filter characters by type', function () {
        Character::factory(3)
            ->sequence(
                ['type' => CharacterType::primary],
                ['type' => CharacterType::secondary],
                ['type' => CharacterType::support],
            )
            ->create();

        livewire(CharactersList::class)
            ->filterTable('type', [CharacterType::primary->value])
            ->assertCountTableRecords(1)
            ->assertCanSeeTableRecords(Character::where('type', CharacterType::primary)->get())
            ->assertCanNotSeeTableRecords(Character::where('type', '!=', CharacterType::primary)->get())
            ->resetTableFilters()
            ->filterTable('type', [CharacterType::secondary->value])
            ->assertCountTableRecords(1)
            ->assertCanSeeTableRecords(Character::where('type', CharacterType::secondary)->get())
            ->assertCanNotSeeTableRecords(Character::where('type', '!=', CharacterType::secondary)->get())
            ->resetTableFilters()
            ->filterTable('type', [CharacterType::support->value])
            ->assertCountTableRecords(4)
            ->assertCanSeeTableRecords(Character::where('type', CharacterType::support)->get())
            ->assertCanNotSeeTableRecords(Character::where('type', '!=', CharacterType::support)->get());
    });

    test('can filter characters by trashed state', function () {
        Character::factory()->create()->delete();

        assertCount(4, Character::withTrashed()->get());

        livewire(CharactersList::class)
            ->assertCountTableRecords(3)
            ->filterTable(TrashedFilter::class, false)
            ->assertCountTableRecords(1);
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
        get(route('characters.index'))->assertSuccessful();
    });

    test('can only see their own characters', function () {
        $characters = Character::factory(3)->hasAttached(Auth::user(), [], 'users')->create();

        $unassignedCharacters = Character::factory(3)->create();

        livewire(CharactersList::class)
            ->assertCountTableRecords(3)
            ->assertCanSeeTableRecords($characters)
            ->assertCanNotSeeTableRecords($unassignedCharacters);
    });
});

describe('unauthenticated user', function () {
    test('cannot view the manage characters page', function () {
        get(route('characters.index'))
            ->assertRedirectToRoute('login');
    });
});
