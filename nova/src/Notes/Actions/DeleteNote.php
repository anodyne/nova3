<?php

namespace Nova\Notes\Actions;

use Nova\Foundation\Action;
use Nova\Notes\Models\Note;

class DeleteNote extends Action
{
    public $errorMessage = 'There was a problem deleting the note';

    public function execute(Note $note): Note
    {
        return $this->call(function () use ($note) {
            return tap($note)->delete();
        });
    }
}
