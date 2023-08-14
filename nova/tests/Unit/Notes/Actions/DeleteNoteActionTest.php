<?php

declare(strict_types=1);

use Nova\Notes\Actions\DeleteNote;
use Nova\Notes\Models\Note;

uses()->group('notes');

it('deletes a note', function () {
    $note = Note::factory()->create();

    $note = DeleteNote::run($note);

    expect($note->exists)->toBeFalse();
});
