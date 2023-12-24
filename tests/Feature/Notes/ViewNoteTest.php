<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Nova\Notes\Models\Note;

use function Pest\Laravel\get;

uses()->group('notes');

describe('authenticated user', function () {
    beforeEach(function () {
        signIn();

        $this->userCreatedNote = Note::factory()->create([
            'user_id' => Auth::id(),
        ]);

        $this->otherUserCreatedNote = Note::factory()->create();
    });

    test('can view their own note', function () {
        get(route('notes.show', $this->userCreatedNote))->assertSuccessful();
    });

    test('cannot view a note created by someone else', function () {
        get(route('notes.show', $this->otherUserCreatedNote))->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    beforeEach(function () {
        $this->note = Note::factory()->create();
    });

    test('cannot view a note', function () {
        get(route('notes.show', $this->note))
            ->assertRedirectToRoute('login');
    });
});
