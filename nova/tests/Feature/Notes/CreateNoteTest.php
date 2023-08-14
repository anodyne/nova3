<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Notes\Events\NoteCreated;
use Nova\Notes\Models\Note;
use Nova\Notes\Requests\CreateNoteRequest;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\get;
use function Pest\Laravel\getJson;
use function Pest\Laravel\post;
use function Pest\Laravel\postJson;

uses()->group('notes');

describe('authenticated user', function () {
    test('can view the create note page', function () {
        $this->signIn();

        get(route('notes.create'))->assertSuccessful();
    });

    test('can create a note', function () {
        Event::fake();

        $this->signIn();

        $data = Note::factory()->make();

        $this->followingRedirects();

        post(route('notes.store'), array_merge($data->toArray(), [
            'editor-content' => $data->content,
        ]))->assertSuccessful();

        Event::assertDispatched(NoteCreated::class);

        $this->assertRouteUsesFormRequest(
            'notes.store',
            CreateNoteRequest::class
        );

        assertDatabaseHas(Note::class, [
            'user_id' => auth()->id(),
            'title' => $data->title,
            'content' => $data->content,
        ]);
    });
});

describe('unauthenticated user', function () {
    test('cannot view the create note page', function () {
        getJson(route('notes.create'))->assertUnauthorized();
    });

    test('cannot create a note', function () {
        postJson(route('notes.store'), $note = Note::factory()->make()->toArray())
            ->assertUnauthorized();

        assertDatabaseMissing(Note::class, [
            'title' => $note['title'],
        ]);
    });
});
