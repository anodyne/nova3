<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\DeleteBulkAction;
use Nova\Notes\Events\NoteDeleted;
use Nova\Notes\Livewire\NotesList;
use Nova\Notes\Models\Note;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Livewire\livewire;

uses()->group('notes');

beforeEach(function () {
    signIn();

    $this->notes = Note::factory()->count(10)->create([
        'user_id' => Auth::id(),
    ]);
});

test('a user can delete their own note', function () {
    Event::fake();

    livewire(NotesList::class)
        ->callTableAction(DeleteAction::class, $this->notes->first())
        ->assertCanNotSeeTableRecords([$this->notes->first()])
        ->assertNotified();

    assertDatabaseMissing(Note::class, $this->notes->first()->toArray());

    Event::assertDispatched(NoteDeleted::class);
});

test("a user cannot delete a note they didn't create", function () {
    $note = Note::factory()->create();

    livewire(NotesList::class)
        ->assertCanNotSeeTableRecords([$note])
        ->assertTableActionHidden(DeleteAction::class, $note);

    assertDatabaseHas(Note::class, $note->toArray());
});

test('a user can bulk delete notes', function () {
    $notes = $this->notes->take(3);

    livewire(NotesList::class)
        ->callTableBulkAction(DeleteBulkAction::class, $notes)
        ->assertNotified();

    foreach ($notes as $note) {
        assertDatabaseMissing(Note::class, $note->toArray());
    }
});
