<?php

declare(strict_types=1);

use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Notes\Livewire\NotesList;
use Nova\Notes\Models\Note;
use function Pest\Laravel\getJson;
use function Pest\Livewire\livewire;

uses()->group('notes');

beforeEach(function () {
    $this->note1 = Note::factory()->create([
        'title' => 'My first note',
        'content' => 'My content',
    ]);

    $this->note2 = Note::factory()->create();
});

describe('authenticated user', function () {
    test('can only see their notes', function () {
        $this->signIn($this->note1->author);

        expect(Note::count())->toBe(2);

        livewire(NotesList::class)
            ->assertCanSeeTableRecords([$this->note1])
            ->assertCanNotSeeTableRecords([$this->note2])
            ->assertCountTableRecords(1)
            ->assertTableColumnExists('title')
            ->assertTableColumnExists('updated_at');
    });

    test('can see the create button', function () {
        $this->signIn();

        livewire(NotesList::class)
            ->assertTableHeaderActionsExistInOrder([
                CreateAction::class,
            ]);
    });

    test('can search their notes', function () {
        Note::factory()->times(5)->create([
            'user_id' => $this->note1->user_id,
        ]);

        $this->signIn($this->note1->author);

        livewire(NotesList::class)
            ->assertCountTableRecords(6)
            ->searchTable('first note')
            ->assertCountTableRecords(1)
            ->searchTable('my content')
            ->assertCountTableRecords(1)
            ->searchTable('foo')
            ->assertCountTableRecords(0);
    });
});

test('unauthenticated user cannot see any notes', function () {
    getJson(route('notes.index'))->assertUnauthorized();
});
