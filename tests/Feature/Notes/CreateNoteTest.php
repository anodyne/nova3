<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Nova\Notes\Events\NoteCreated;
use Nova\Notes\Models\Note;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses()->group('notes');

describe('authenticated user', function () {
    beforeEach(function () {
        signIn();
    });

    test('can view the create note page', function () {
        get(route('admin.notes.create'))->assertSuccessful();
    });

    test('can create a note', function () {
        Event::fake();

        $data = Note::factory()->make([
            'user_id' => Auth::id(),
        ]);

        from(route('admin.notes.create'))
            ->followingRedirects()
            ->post(route('admin.notes.store'), $data->toArray())
            ->assertSuccessful();

        assertDatabaseHas(Note::class, $data->toArray());

        Event::assertDispatched(NoteCreated::class);
    });
});

describe('unauthenticated user', function () {
    test('cannot view the create note page', function () {
        get(route('admin.notes.create'))
            ->assertRedirectToRoute('login');
    });

    test('cannot create a note', function () {
        post(route('admin.notes.store'), [])
            ->assertRedirectToRoute('login');
    });
});
