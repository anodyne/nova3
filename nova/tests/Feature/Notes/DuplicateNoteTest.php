<?php

declare(strict_types=1);

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
    $this->note1 = Note::factory()->create();
    $this->note2 = Note::factory()->create();
});

describe('authenticated user', function () {
    test('can duplicate a note they created', function () {
        Event::fake();

        $this->signIn($this->note1->author);

        livewire(NotesList::class)
            ->assertCanSeeTableRecords([$this->note1])
            ->callTableAction(ReplicateAction::class, $this->note1)
            ->assertNotified();

        Event::assertDispatched(NoteDuplicated::class);

        assertDatabaseHas(Note::class, [
            'title' => "Copy of {$this->note1->title}",
        ]);
    });

    test('cannot duplicate a note they did not create', function () {
        $this->signIn($this->note2->author);

        livewire(NotesList::class)
            ->assertCanNotSeeTableRecords([$this->note1])
            ->assertTableActionHidden(ReplicateAction::class, $this->note1);

        assertDatabaseMissing(Note::class, [
            'title' => "Copy of {$this->note1->title}",
        ]);
    });
});

test('unauthenticated user cannot duplicate note', function () {
    livewire(NotesList::class)
        ->assertCanNotSeeTableRecords([$this->note1, $this->note2])
        ->assertCountTableRecords(0)
        ->assertTableActionHidden(ReplicateAction::class, $this->note1)
        ->assertTableActionHidden(ReplicateAction::class, $this->note2);

    assertDatabaseMissing(Note::class, [
        'title' => "Copy of {$this->note1->title}",
    ]);

    assertDatabaseMissing(Note::class, [
        'title' => "Copy of {$this->note2->title}",
    ]);
});
