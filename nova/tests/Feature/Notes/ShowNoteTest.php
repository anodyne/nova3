<?php

declare(strict_types=1);

use Nova\Notes\Models\Note;
use function Pest\Laravel\get;
use function Pest\Laravel\getJson;

uses()->group('notes');

beforeEach(function () {
    $this->note = Note::factory()->create();
});

describe('authenticated user', function () {
    test('can view one of their notes', function () {
        $this->signIn($this->note->author);

        get(route('notes.show', $this->note))
            ->assertSuccessful()
            ->assertViewHas('note', $this->note);
    });

    test('cannot view a note they did not create', function () {
        $this->signIn();

        get(route('notes.show', $this->note))->assertForbidden();
    });
});

test('unauthenticated user cannot view a note', function () {
    getJson(route('notes.show', $this->note))->assertUnauthorized();
});
