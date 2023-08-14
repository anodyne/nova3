<?php

declare(strict_types=1);

use Nova\Notes\Actions\UpdateNote;
use Nova\Notes\Data\NoteData;
use Nova\Notes\Models\Note;

uses()->group('notes');

it('updates a note', function () {
    $note = Note::factory()->create([
        'title' => 'My First Note',
        'content' => 'Content',
    ]);

    $data = NoteData::from([
        'title' => 'My Note',
        'content' => 'New content',
    ]);

    $note = UpdateNote::run($note, $data);

    expect($note->title)->toEqual('My Note');
    expect($note->content)->toEqual('New content');
});
