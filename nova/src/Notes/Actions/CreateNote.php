<?php

namespace Nova\Notes\Actions;

use Nova\Foundation\Action;
use Nova\Notes\Models\Note;
use Nova\Notes\DataTransferObjects\NoteData;

class CreateNote extends Action
{
    public $errorMessage = 'There was a problem creating the note';

    public function execute(NoteData $data): Note
    {
        return $this->call(function () use ($data) {
            return Note::create($data->toArray());
        });
    }
}
