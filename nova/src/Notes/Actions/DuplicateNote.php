<?php

namespace Nova\Notes\Actions;

use Nova\Foundation\Action;
use Nova\Notes\Models\Note;

class DuplicateNote extends Action
{
    public $errorMessage = 'There was a problem duplicating the note';

    public function execute(Note $originalNote): Note
    {
        return $this->call(function () use ($originalNote) {
            $note = $originalNote->replicate();

            $note->title = "Copy of {$note->title}";

            $note->save();

            return $note->refresh();
        });
    }
}
