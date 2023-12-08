<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Nova\Foundation\Filament\Actions\ReplicateAction;
use Nova\Notes\Events\NoteDuplicated;
use Nova\Notes\Livewire\NotesList;
use Nova\Notes\Models\Note;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Livewire\livewire;

uses()->group('notes');

beforeEach(function () {
    signIn();

    $this->note = Note::factory()->create([
        'user_id' => Auth::id(),
    ]);
});

test('a user can duplicate one of their notes', function () {
    Event::fake();

    livewire(NotesList::class)
        ->callTableAction(ReplicateAction::class, $this->note)
        ->assertNotified();

    assertDatabaseHas(Note::class, [
        'title' => 'Copy of '.$this->note->title,
    ]);

    Event::assertDispatched(NoteDuplicated::class);
});

test("a user cannot duplicate a note they didn't create", function () {
    $note = Note::factory()->create();

    livewire(NotesList::class)
        ->assertCanNotSeeTableRecords([$note])
        ->assertTableActionHidden(ReplicateAction::class, $note);

    assertDatabaseMissing(Note::class, [
        'title' => 'Copy of '.$note->title,
    ]);
});
