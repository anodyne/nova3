<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Nova\Notes\Livewire\NotesList;
use Nova\Notes\Models\Note;
use Nova\Users\Models\User;

use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

uses()->group('notes');

describe('authenticated user', function () {
    beforeEach(function () {
        signIn();

        $user = User::factory()->create();

        $this->notes = Note::factory()
            ->count(10)
            ->sequence(
                ['user_id' => Auth::id()],
                ['user_id' => $user->id],
            )
            ->create();
    });

    test('can only see their own notes on the list notes page', function () {
        get(route('notes.index'))->assertSuccessful();

        livewire(NotesList::class)
            ->assertCanSeeTableRecords($this->notes->where('user_id', Auth::id()))
            ->assertCanNotSeeTableRecords($this->notes->where('user_id', '!=', Auth::id()));
    });

    test('can search notes by title', function () {
        livewire(NotesList::class)
            ->searchTable('banana')
            ->assertCountTableRecords(0)
            ->searchTable($this->notes->where('user_id', Auth::id())->first()->title)
            ->assertCountTableRecords(1);
    });
});

describe('unauthenticated user', function () {
    test('cannot view the manage notes page', function () {
        get(route('notes.index'))
            ->assertRedirect(route('login'));
    });
});
