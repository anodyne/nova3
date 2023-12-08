<?php

declare(strict_types=1);

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Nova\Notes\Events\NoteUpdated;
use Nova\Notes\Models\Note;
use Nova\Ranks\Models\RankName;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\put;

uses()->group('notes');

beforeEach(function () {
    $this->rankName = RankName::factory()->create();
});

describe('authenticated user', function () {
    beforeEach(function () {
        signIn();

        $this->note = Note::factory()->create([
            'user_id' => Auth::id(),
        ]);
    });

    test('can view the edit note page', function () {
        get(route('notes.edit', $this->note))->assertSuccessful();
    });

    test('can update a note', function () {
        Event::fake();

        $data = Note::factory()->make();

        from(route('notes.edit', $this->note))
            ->followingRedirects()
            ->put(route('notes.update', $this->note), Arr::except($data->toArray(), 'user_id'))
            ->assertSuccessful();

        assertDatabaseHas(Note::class, Arr::except($data->toArray(), 'user_id'));

        Event::assertDispatched(NoteUpdated::class);
    });
});

describe('unauthenticated user', function () {
    beforeEach(function () {
        $this->note = Note::factory()->create();
    });

    test('cannot view the edit note page', function () {
        get(route('notes.edit', $this->note))
            ->assertRedirect(route('login'));
    });

    test('cannot update a note', function () {
        put(route('notes.update', $this->note), [])
            ->assertRedirect(route('login'));
    });
});
