<?php

declare(strict_types=1);

use Nova\Notes\Actions\DuplicateNote;
use Nova\Notes\Models\Note;

uses()->group('notes');

it('duplicates a note', function () {
    $original = Note::factory()->create([
        'title' => 'My Note',
        'content' => 'Content',
    ]);

    $note = DuplicateNote::run($original);

    expect($note->title)->toEqual('Copy of My Note');
    expect($note->content)->toEqual('Content');
});
