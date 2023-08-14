<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Notes\Events\NoteUpdated;
use Nova\Notes\Models\Note;
use Nova\Notes\Requests\UpdateNoteRequest;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\get;
use function Pest\Laravel\getJson;
use function Pest\Laravel\put;
use function Pest\Laravel\putJson;

uses()->group('notes');

beforeEach(function () {
    $this->note1 = Note::factory()->create();
    $this->note2 = Note::factory()->create();
});

describe('authenticated user', function () {
    test('can view the edit note page', function () {
        $this->signIn($this->note1->author);

        get(route('notes.edit', $this->note1))->assertSuccessful();
    });

    test('can update a note they created', function () {
        Event::fake();

        $this->signIn($this->note1->author);

        $this->followingRedirects();

        put(route('notes.update', $this->note1), [
            'title' => 'New Title',
            'editor-content' => 'New content',
        ])
            ->assertSuccessful();

        Event::assertDispatched(NoteUpdated::class);

        $this->assertRouteUsesFormRequest(
            'notes.update',
            UpdateNoteRequest::class
        );

        assertDatabaseHas('notes', [
            'id' => $this->note1->id,
            'title' => 'New Title',
            'content' => 'New content',
        ]);
    });

    test('cannot view the edit page of a note they did not create', function () {
        $this->signIn($this->note2->author);

        get(route('notes.edit', $this->note1))->assertForbidden();
    });

    test('cannot update a note they did not create', function () {
        $this->signIn($this->note2->author);

        putJson(route('notes.update', $this->note1), [
            'title' => 'Foo',
        ])
            ->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the edit note page', function () {
        getJson(route('notes.edit', $this->note1))->assertUnauthorized();
    });

    test('cannot update a note', function () {
        putJson(route('notes.update', $this->note1), [])->assertUnauthorized();
    });
});
