<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Notes\Events\NoteDeleted;
use Nova\Notes\Livewire\NotesList;
use Nova\Notes\Models\Note;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Livewire\livewire;

uses()->group('notes');

beforeEach(function () {
    $this->note1 = Note::factory()->create();
    $this->note2 = Note::factory()->create();
});

describe('authenticated user', function () {
    test('can delete a note they created', function () {
        Event::fake();

        $this->signIn($this->note1->author);

        livewire(NotesList::class)
            ->assertCanSeeTableRecords([$this->note1])
            ->assertCountTableRecords(1)
            ->assertTableActionVisible(DeleteAction::class, $this->note1)
            ->callTableAction(DeleteAction::class, $this->note1)
            ->assertNotified();

        Event::assertDispatched(NoteDeleted::class);

        assertDatabaseMissing(Note::class, [
            'id' => $this->note1->id,
        ]);
    });

    test('cannot delete a note they did not create', function () {
        $this->signIn($this->note2->author);

        livewire(NotesList::class)
            ->assertCanNotSeeTableRecords([$this->note1])
            ->assertTableActionHidden(DeleteAction::class, $this->note1);

        assertDatabaseHas(Note::class, [
            'id' => $this->note1->id,
        ]);
    });
});

test('unauthenticated user cannot delete note', function () {
    livewire(NotesList::class)
        ->assertCanNotSeeTableRecords([$this->note1, $this->note2])
        ->assertCountTableRecords(0)
        ->assertTableActionHidden(DeleteAction::class, $this->note1)
        ->assertTableActionHidden(DeleteAction::class, $this->note2);

    assertDatabaseHas(Note::class, [
        'id' => $this->note1->id,
    ]);

    assertDatabaseHas(Note::class, [
        'id' => $this->note2->id,
    ]);
});
