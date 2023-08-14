<?php

declare(strict_types=1);

use Nova\Notes\Actions\CreateNote;
use Nova\Notes\Data\NoteData;

uses()->group('notes');

it('creates a new note', function () {
    $this->signIn();

    $data = NoteData::from([
        'title' => 'My Note',
        'content' => 'Content of my note',
    ]);

    $note = CreateNote::run($data);

    expect($note->exists)->toBeTrue();
    expect($note->title)->toEqual('My Note');
    expect($note->content)->toEqual('Content of my note');
    expect($note->user_id)->toEqual(auth()->id());
});
